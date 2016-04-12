<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Checkout;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\Cart\Cart;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Request;
use Session;
use View;

class CheckoutController extends VendirunBaseController {

    /**
     * @var bool
     */
    protected $primaryPages = true;
    
    public function index()
    {
        $countryId = null;
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

        $shippingTypeId = Request::get('shippingTypeId', null);
        $countryId = $this->_getDefaultCountry($data['customer']);

        $cart = new Cart([], $countryId, $shippingTypeId);
        $data['cart'] = $cart->getProducts();


        $paymentGateways = VendirunApi::makeRequest('client/paymentGateways')->getData();
        $data['stripe'] = false;
        $data['paypal'] = false;
        foreach ($paymentGateways as $key => $gateway) $data[$key] = true;

        return View::make('vendirun::checkout.checkout', $data);
    }

    public function confirmOrder()
    {

    }
    
}