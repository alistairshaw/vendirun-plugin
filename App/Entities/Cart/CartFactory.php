<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItemFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
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
     * @param $items
     * @return Cart
     */
    public function makeFromIds($items)
    {
        $clientInfo = Config::get('clientInfo');
        $priceIncludesTax = $clientInfo->business_settings->tax->price_includes_tax;

        $cartItemFactory = new CartItemFactory($this->cartRepository);
        $products = $cartItemFactory->makeFromIds($items, $priceIncludesTax);

        $params = [
            'ids' => $items,
            'items' => $products,
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => $clientInfo->business_settings->tax->charge_tax_on_shipping,
            'defaultTaxRate' => $clientInfo->business_settings->tax->default_tax_rate,
        ];

        return new Cart($params);
    }

    /**
     * CartFactory constructor.
     * @param null  $countryId
     * @param null  $shippingType
     * @return Cart
     */
    /*public function make($countryId = null, $shippingType = null)
    {
        // if no country select a default
        if (!$countryId) $countryId = CustomerHelper::getDefaultCountry();

        $productVariationIds = $this->cartRepository->getCart();
        $products = $this->cartRepository->getProducts()->result;
        $availableShippingTypes = ShippingCalculator::availableShippingTypes($products, $countryId);

        if ((count($availableShippingTypes) > 0) && !in_array($shippingType, $availableShippingTypes)) $shippingType = $availableShippingTypes[0];
        if (count($availableShippingTypes) == 0) $shippingType = '';

        $clientInfo = Config::get('clientInfo');
        $priceIncludesTax = $clientInfo->business_settings->tax->price_includes_tax;

        $orderShippingPrice = ShippingCalculator::orderShippingCharge($products, $countryId, $shippingType);

        $cartItemFactory = new CartItemFactory($this->cartRepository, $countryId, $shippingType);

        $params = [
            'ids' => $productVariationIds,
            'items' => $cartItemFactory->makeFromIds($priceIncludesTax),
            'countryId' => $countryId,
            'shippingType' => $shippingType,
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => $clientInfo->business_settings->tax->charge_tax_on_shipping,
            'defaultTaxRate' => $clientInfo->business_settings->tax->default_tax_rate,
            'orderShippingPrice' => $orderShippingPrice,
            'availableShippingTypes' => $availableShippingTypes,
        ];

        return new Cart($params);
    }*/

}