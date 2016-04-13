<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Checkout;

use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Order\OrderFactory;
use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Http\Requests\OrderRequest;
use AlistairShaw\Vendirun\App\Lib\Cart\Cart;
use AlistairShaw\Vendirun\App\Lib\Cart\Order;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
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
        $data['cart'] = $cartFactory->make(Request::input('countryId', null), Request::input('shippingType', null));
        $data['paymentGateways'] = $this->getPaymentGateways();

        return View::make('vendirun::checkout.checkout', $data);
    }

    /**
     * @return $this
     */
    public function recalculateShipping()
    {
        return Redirect::route('vendirun.checkout', ['countryId' => Request::get('shippingcountryId'), 'shippingTypeId' => Request::get('shippingTypeId')])->withInput();
    }

    /**
     * @param OrderRequest    $request
     * @param CartRepository  $cartRepository
     * @param OrderRepository $orderRepository
     * @return $this|CheckoutController|\Illuminate\Http\RedirectResponse
     */
    public function process(OrderRequest $request, CartRepository $cartRepository, OrderRepository $orderRepository)
    {
        if (Request::has('recalculateShipping')) return $this->recalculateShipping();

        $gateways = $this->getPaymentGateways();

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
        $cart = $cartFactory->make(Request::input('countryId', null), Request::input('shippingType', null));

        $orderFactory = new OrderFactory($orderRepository);
        $order = $orderFactory->fromCart($cart, Request::all());
        $orderRepository->saveOrder($order);
        dd('ORDER CREATED');

        if (!$gateways->paypal) return $this->processStripe($gateways->stripeSettings, $cart, $order);
        if (!$gateways->stripe) return $this->processPaypal($gateways->paypalSettings);

        if (Request::input('paymentOption') == 'stripe') return $this->processStripe($gateways->stripeSettings, $cart, $order);

        return $this->processPaypal($gateways->paypalSettings);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function success()
    {
        return View::make('vendirun::checkout.success');
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
     * @param $settings
     * @param $cart
     * @param $order
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    private function processStripe($settings, $cart, $order)
    {
        Stripe::setApiKey($settings->sandbox_mode ? $settings->test_secret : $settings->secret);

        // Create the charge on Stripe's servers - this will charge the user's card
        try
        {
            $clientInfo = Config::get('clientInfo');
            $cartProducts = $cart->getProducts();
            $token = Request::get('stripeToken');
            
            $charge = Charge::create(array(
                "amount" => $cartProducts->total + $cartProducts->shipping,
                "currency" => "gbp",
                "source" => $token,
                "description" => $clientInfo->name,
                "metadata" => [
                    "order_id" => "6735"
                ]
            ));

            return Redirect::route('vendirun.checkoutSuccess');
        }
        catch (Card $e)
        {
            return Redirect::back()->with('paymentError', trans('vendirun::checkout.cardDeclined'))->withInput();
        }
        catch (\Exception $e)
        {
            return Redirect::back()->with('paymentError', 'Payment Has Been Taken - ORDER not saved correctly, please call Customer Services.')->withInput();
        }
    }

    /**
     * @param $settings
     * @return mixed
     */
    private function processPaypal($settings)
    {
        return dd("Process with Paypal");
    }

}