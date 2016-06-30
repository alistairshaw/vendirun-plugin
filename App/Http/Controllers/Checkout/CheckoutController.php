<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Checkout;

use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\CustomerFactory;
use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Entities\Order\Order;
use AlistairShaw\Vendirun\App\Entities\Order\OrderFactory;
use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;
use AlistairShaw\Vendirun\App\Exceptions\CustomerNotFoundException;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Http\Requests\OrderRequest;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\PaymentGateway\PaypalPaymentGateway;
use AlistairShaw\Vendirun\App\Lib\PaymentGateway\StripePaymentGateway;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\ValueObjects\Name;
use Redirect;
use Request;
use Session;
use View;

class CheckoutController extends VendirunBaseController {

    /**
     * @param CartRepository     $cartRepository
     * @param CustomerRepository $customerRepository
     * @return \Illuminate\Contracts\View\View
     */
    public function index(CartRepository $cartRepository, CustomerRepository $customerRepository)
    {
        $this->setPrimaryPath();
        
        try
        {
            $data['customer'] = $customerRepository->find();
            $data['defaultAddress'] = $data['customer'] ? $data['customer']->getPrimaryAddress() : NULL;
        }
        catch (CustomerNotFoundException $e)
        {
            $data['customer'] = null;
            $data['defaultAddress'] = null;
        }

        $countryId = NULL;
        $countryId = CustomerHelper::getDefaultCountry();
        if ($data['defaultAddress']) $countryId = $data['defaultAddress']->getCountryId();
        if (Request::old('shippingaddressId')) $countryId = $data['customer']->getAddressFromAddressId(Request::old('shippingaddressId'))->getCountryId();

        $cart = $cartRepository->find();
        $cart->setCountryId($countryId);
        if (Request::get('shippingTypeId')) $cart->setShippingType(Request::get('shippingTypeId'));

        if ($cart->count() == 0) return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.productCart');

        $data['cart'] = $cart;
        $data['displayTotals'] = $cart->getFormattedTotals();

        return View::make('vendirun::checkout.checkout', $data);
    }

    /**
     * @param CustomerRepository $customerRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recalculateShipping(CustomerRepository $customerRepository)
    {
        $customer = $customerRepository->find();

        $countryId = NULL;
        $countryId = CustomerHelper::getDefaultCountry();
        if (Request::has('countryId')) $countryId = Request::get('countryId');
        if (Request::has('shippingaddressId'))
        {
            $customerCountryId = $customer->getAddressFromAddressId(Request::get('shippingaddressId'));
            if ($customerCountryId) $countryId = $customerCountryId->getCountryId();
        }

        return Redirect::route('vendirun.checkout', ['countryId' => $countryId, 'shippingTypeId' => Request::get('shippingTypeId', NULL)])->withInput();
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
        if (Request::has('recalculateShipping')) return $this->recalculateShipping($customerRepository);
        if (Request::has('orderId')) return $this->processExistingOrder($orderRepository, Request::get('orderId'));

        // construct the customer
        $customerFactory = new CustomerFactory();
        try
        {
            $customer = $customerRepository->find();
            $customer->setName(Name::fromFullName(Request::get('fullName')));
            $customer->setPrimaryEmail(Request::get('emailAddress'));
        }
        catch (CustomerNotFoundException $e)
        {
            $customer = $customerFactory->make(null, Request::get('emailAddress'), Request::get('fullName'));
        }

        // get country ID from the shipping address
        $shippingAddressId = $request->get('shippingaddressId');
        $shippingAddress = $customer->getAddressFromAddressId($shippingAddressId);
        $countryId = $shippingAddress ? $shippingAddress->getCountryId() : $request->get('shippingcountryId');

        // construct the cart
        $cart = $cartRepository->find();
        $cart->setCountryId($countryId);
        if (Request::get('shippingType')) $cart->setShippingType(Request::get('shippingType'));

        // if cart is empty go back to main checkout page
        if ($cart->count() == 0) return Redirect::back()->with('paymentError', 'No items in your cart')->withInput();

        // convert cart to order
        $orderFactory = new OrderFactory();
        $order = $orderFactory->fromCart($cart, $customer, Request::all());

        // persist the order
        if (!$order = $orderRepository->save($order)) return Redirect::back()->with('paymentError', 'Payment Has NOT Been Taken - unable to create order, please try again');
        Session::set('orderOneTimeToken', $order->getOneTimeToken());

        return $this->takePayment($orderRepository, $order);
    }

    /**
     * @param OrderRepository $orderRepository
     * @param $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    private function processExistingOrder(OrderRepository $orderRepository, $orderId)
    {
        if (!$order = $orderRepository->find($orderId)) return Redirect::back()->with('paymentError', 'Invalid Order ID');

        return $this->takePayment($orderRepository, $order);
    }

    /**
     * @param OrderRepository $orderRepository
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    private function takePayment(OrderRepository $orderRepository, Order $order)
    {
        // instantiate correct payment gateway implementation
        $paymentGateway = NULL;
        if (Request::input('paymentOption') == 'stripe')
        {
            $paymentGateway = new StripePaymentGateway($order, $orderRepository);
            $paymentGateway->setStripeToken(Request::get('stripeToken'));
        }
        if (Request::input('paymentOption') == 'paypal')
        {
            $paymentGateway = new PaypalPaymentGateway($order, $orderRepository);
            $paymentGateway->setUrls(
                route(LocaleHelper::localePrefix() . 'vendirun.checkoutPaypalSuccess', ['orderId' => $order->getId()]),
                route(LocaleHelper::localePrefix() . 'vendirun.checkoutFailure', ['orderId' => $order->getId()])
            );
        }
        if (!$paymentGateway) return Redirect::back()->with('paymentError', 'No valid payment gateway selected')->withInput();

        // take the payment
        try
        {
            $redirectTo = $paymentGateway->takePayment();
            if ($redirectTo) return Redirect::to($redirectTo);
        }
        catch (\Exception $e)
        {
            dd($e);
            return Redirect::back()->with('paymentError', $e->getMessage())->withInput();
        }

        return Redirect::route('vendirun.checkoutSuccess', ['orderId' => $order->getId()]);
    }

    /**
     * @param OrderRepository $orderRepository
     * @param CartRepository $cartRepository
     * @param int $orderId
     * @return \Illuminate\Contracts\View\View
     */
    public function success(OrderRepository $orderRepository, CartRepository $cartRepository, $orderId)
    {
        // clear the cart when payment succeeds
        $cartRepository->save($cartRepository->find()->clear());

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
     * @param OrderRepository   $orderRepository
     * @param int               $orderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paypalSuccess(OrderRepository $orderRepository, $orderId)
    {
        $order = $orderRepository->find($orderId, Session::get('orderOneTimeToken', NULL));

        $paymentGateway = new PaypalPaymentGateway($order, $orderRepository);
        $paymentGateway->confirmPayment(Request::all());
        
        return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.checkoutSuccess', ['orderId' => $order->getId()]);
    }

    /**
     * @param OrderRepository $orderRepository
     * @param CartRepository $cartRepository
     * @param int $orderId
     * @return \Illuminate\Contracts\View\View
     */
    public function failure(OrderRepository $orderRepository, CartRepository $cartRepository, $orderId)
    {
        // clear the cart because the order already exists
        $cartRepository->save($cartRepository->find()->clear());

        // if NULL, we'll get the most recent order from session
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

        return View::make('vendirun::checkout.failure', $data);
    }

}