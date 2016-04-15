<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItemFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Config;
use Request;
use Session;

class CartFactory {

    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * CartFactory constructor.
     * @param CartRepository $cartRepository
     */
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * CartFactory constructor.
     * @param null  $countryId
     * @param null  $shippingType
     * @return Cart
     */
    public function make($countryId = null, $shippingType = null)
    {
        // if no country select a default
        if (!$countryId) $countryId = $this->getDefaultCountry();

        $productVariationIds = $this->cartRepository->getCart();
        $products = $this->cartRepository->getProducts($productVariationIds)->result;
        $availableShippingTypes = ShippingCalculator::availableShippingTypes($products, $countryId);

        if ((count($availableShippingTypes) > 0) && !in_array($shippingType, $availableShippingTypes)) $shippingType = $availableShippingTypes[0];
        if (count($availableShippingTypes) == 0) $shippingType = '';

        $clientInfo = Config::get('clientInfo');
        $priceIncludesTax = $clientInfo->business_settings->tax->price_includes_tax;

        $orderShippingPrice = ShippingCalculator::orderShippingCharge($products, $countryId, $shippingType);

        $cartItemFactory = new CartItemFactory($this->cartRepository, $countryId, $shippingType);

        $params = [
            'ids' => $productVariationIds,
            'items' => $cartItemFactory->makeFromIds($productVariationIds, $priceIncludesTax),
            'countryId' => $countryId,
            'shippingType' => $shippingType,
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => $clientInfo->business_settings->tax->charge_tax_on_shipping,
            'defaultTaxRate' => $clientInfo->business_settings->tax->default_tax_rate,
            'orderShippingPrice' => $orderShippingPrice,
            'availableShippingTypes' => $availableShippingTypes,
        ];

        return new Cart($this->cartRepository, $params);
    }

    /**
     * @return int
     */
    private function getDefaultCountry()
    {
        // if country ID is in the GET then obviously, that
        if (Request::has('countryId')) return Request::get('countryId');

        // if user is logged in, get their primary address country
        if (Session::has('token'))
        {
            $customer = VendirunApi::makeRequest('customer/find', ['token' => Session::get('token')])->getData();
            if (count($customer->primary_address) > 0 && $customer->primary_address->country_id)
            {
                return $customer->primary_address->country_id;
            }
        }

        // get company default country
        $clientInfo = Config::get('clientInfo');
        if ($clientInfo->country_id) return $clientInfo->country_id;

        // use UK as super-default if company default not set
        return 79;
    }

}