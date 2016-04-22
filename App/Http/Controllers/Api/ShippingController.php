<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use Request;

class ShippingController extends ApiBaseController {

    /**
     * Returns full list of available actions with the relevant URI listed
     * @param CartRepository $cartRepository
     * @return array
     */
    public function calculate(CartRepository $cartRepository)
    {
        try
        {
            $cartFactory = new CartFactory($cartRepository);
            $cart = $cartFactory->make(Request::get('countryId', NULL), Request::get('shippingTypeId', NULL));

            return $this->respond(true, [
                'totals' => $cart->getFormattedTotals(),
                'shippingTypeId' => $cart->getShippingType(),
                'countryId' => $cart->getCountryId(),
                'availableShippingTypes' => $cart->getAvailableShippingTypes()
            ]);
        }
        catch (\Exception $e)
        {
            return $this->respond(false);
        }
    }

}