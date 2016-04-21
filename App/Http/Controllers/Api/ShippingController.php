<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use Request;

class ShippingController extends VendirunBaseController {

    /**
     * Returns full list of available actions with the relevant URI listed
     * @param CartRepository $cartRepository
     * @return array
     */
    public function calculate(CartRepository $cartRepository)
    {
        $cartFactory = new CartFactory($cartRepository);
        $cart = $cartFactory->make(Request::get('countryId', null), Request::get('shippingType', NULL));

        return $cart->displayShipping();
    }

}