<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Checkout;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\CustomerFactory;
use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Order\Order;
use AlistairShaw\Vendirun\App\Entities\Order\OrderFactory;
use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Http\Requests\OrderRequest;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use AlistairShaw\Vendirun\App\ValueObjects\Name;
use Config;
use Redirect;
use Request;
use Session;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;
use View;

class CheckoutController extends VendirunBaseController {

    /**
     * @var bool
     */
    protected $primaryPages = true;

    /**
     * @param CartRepository $cartRepository
     * @return \Illuminate\Contracts\View\View
     */
    public function index(CartRepository $cartRepository)
    {
        $countryId = NULL;
        $data['customer'] = false;
        if (Session::has('token'))
        {
            try
            {
                $data['customer'] = VendirunApi::makeRequest('customer/find', ['token' => Session::get('token')])->getData();
            }
            catch (FailResponseException $e)
            {
                // if we get a fail response, means customer is invalid, remove token from session
                Session::remove('token');
            }
        }

        $cartFactory = new CartFactory($cartRepository);
        $data['cart'] = $cartFactory->make(Request::input('countryId', NULL), Request::input('shippingType', NULL));
        $data['paymentGateways'] = $this->getPaymentGateways();

        if (count($data['cart']->getItems()) == 0) return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.productCart');

        return View::make('vendirun::checkout.checkout', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recalculateShipping()
    {
        return Redirect::route('vendirun.checkout', ['countryId' => Request::get('shippingcountryId'), 'shippingTypeId' => Request::get('shippingTypeId')]);
    }

    /**
     * @param OrderRequest       $request
     * @param CartRepository     $cartRepository
     * @param OrderRepository    $orderRepository
     * @param CustomerRepository $customerRepository
     * @return $this|CheckoutController|\Illuminate\Http\RedirectResponse
     */
    public function process(OrderRequest $request, CartRepository $cartRepository, OrderRepository $orderRepository, CustomerRepository $customerRepository)
    {
        if (Request::has('recalculateShipping')) return $this->recalculateShipping();

        // Create new order
        if ($request->get('shippingcountryId'))
        {
            $countryId = $request->get('shippingcountryId');
        }
        else
        {
            //todo: get country from shipping address ID
            $countryId = '';
        }

        $cartFactory = new CartFactory($cartRepository);
        $cart = $cartFactory->make($countryId, Request::input('shippingType', NULL));

        $name = new Name(Request::get('fullName'));
        $email = Request::get('email');

        if (Session::has('token'))
        {
            $customer = $customerRepository->find(Session::get('token'));
            $customer->setName($name);
            $customer->setPrimaryEmail($email);
            $customerRepository->save($customer);
        }
        else
        {
            $customerFactory = new CustomerFactory($customerRepository);
            $customer = $customerFactory->make(NULL, Request::get('fullName'), Request::get('emailAddress'));
        }

        $orderFactory = new OrderFactory($orderRepository);
        $order = $orderFactory->fromCart($cart, $customer, Request::all());

        if (!$order = $orderRepository->save($order))
        {
            return Redirect::back()->with('paymentError', 'Payment Has NOT Been Taken - unable to create order, please try again');
        }

        Session::set('orderOneTimeToken', $order->getOneTimeToken());

        //$cartRepository->clear(); //todo put this back

        return $this->processPayment($order);
    }

    /**
     * @param OrderRepository $orderRepository
     * @param int             $orderId
     * @return \Illuminate\Contracts\View\View
     */
    public function success(OrderRepository $orderRepository, $orderId)
    {
        // if null, we'll get the most recent order from session
        try
        {
            $data['order'] = $orderRepository->find($orderId, Session::get('orderOneTimeToken', NULL));
            Session::remove('orderOneTimeToken');
        }
        catch (FailResponseException $e)
        {
            // if we can't find a valid order, might just be that the session has expired,
            //    in which case we just won't show the order details
            $data['order'] = NULL;
        }

        return View::make('vendirun::checkout.success', $data);
    }

    /**
     * @return object
     */
    private function getPaymentGateways()
    {
        $paymentGateways = VendirunApi::makeRequest('client/paymentGateways')->getData();
        $data['stripe'] = false;
        $data['paypal'] = false;
        foreach ($paymentGateways as $key => $gateway)
        {
            $data[$key] = true;
            $data[$key . 'Settings'] = $gateway;
        }

        return (object)$data;
    }

    /**
     * @param $order
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    private function processPayment($order)
    {
        $gateways = $this->getPaymentGateways();

        $paymentError = 'No valid payment gateway available';

        if (Request::input('paymentOption') == 'stripe') $paymentError = $this->processStripe($gateways->stripeSettings, $order);
        if (Request::input('paymentOption') == 'paypal') $paymentError = $this->processPaypal($gateways->paypalSettings, $order);

        if ($paymentError !== '') return Redirect::back()->with('paymentError', $paymentError)->withInput();

        return Redirect::route('vendirun.checkoutSuccess', ['orderId' => $order->getId()]);
    }

    /**
     * @param $settings
     * @param $order
     * @return string
     */
    private function processStripe($settings, Order $order)
    {
        Stripe::setApiKey($settings->sandbox_mode ? $settings->test_secret : $settings->secret);

        // Create the charge on Stripe's servers - this will charge the user's card
        try
        {
            $clientInfo = Config::get('clientInfo');
            $token = Request::get('stripeToken');

            $charge = Charge::create(array(
                "amount" => $order->getTotalPrice(),
                "currency" => $clientInfo->currency->currency_iso,
                "source" => $token,
                "description" => $clientInfo->name,
                "metadata" => [
                    "order_id" => $order->getId()
                ]
            ));

            $chargeObject = json_decode($charge->getLastResponse()->body);

            $this->addPayment($order, $chargeObject->amount, 'Stripe', $chargeObject);
        }
        catch (Card $e)
        {
            return trans('vendirun::checkout.cardDeclined');
        }
        catch (\Exception $e)
        {
            return 'Payment Has Been Taken - ORDER not saved correctly, please call Customer Services.';
        }

        return '';
    }

    /**
     * @param $settings
     * @return mixed
     */
    private function processPaypal($settings, Order $order)
    {
        return 'Paypal gateway not enabled';
        // return dd("Process with Paypal");
    }

    /**
     * @param Order $order
     * @param       $paymentAmount
     * @param       $paymentType
     * @param       $transactionData
     */
    private function addPayment(Order $order, $paymentAmount, $paymentType, $transactionData)
    {
        $params = [
            'order_id' => $order->getId(),
            'payment_amount' => $paymentAmount,
            'payment_date' => date("Y-m-d"),
            'payment_type' => $paymentType,
            'transaction_data' => $transactionData
        ];

        VendirunApi::makeRequest('order/payment', $params);
    }

}