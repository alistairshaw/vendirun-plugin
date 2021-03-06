<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItemFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesTransformer;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption\ProductTaxOptionFactory;
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
     * @var CartValuesTransformer
     */
    private $cartValuesTransformer;

    /**
     * CartFactory constructor.
     * @param CartRepository $cartRepository
     * @param CartValuesTransformer $cartValuesTransformer
     */
    public function __construct(CartRepository $cartRepository, CartValuesTransformer $cartValuesTransformer)
    {
        $this->cartRepository = $cartRepository;
        $this->cartValuesTransformer = $cartValuesTransformer;
    }

    /**
     * @param $items
     * @param null $countryId
     * @param string $shippingType
     * @return Cart
     */
    public function makeFromIds($items, $countryId = null, $shippingType = '')
    {
        $clientInfo = Config::get('clientInfo');
        $priceIncludesTax = $clientInfo->business_settings->tax->price_includes_tax;

        $taxes = ProductTaxOptionFactory::makeFromApi($clientInfo->business_settings->tax->country_tax_rates);
        $defaultTaxRate = TaxCalculator::calculateProductTaxRate($taxes, $countryId, $clientInfo->business_settings->tax->default_tax_rate);

        $params = [
            'ids' => $items,
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => $clientInfo->business_settings->tax->charge_tax_on_shipping,
            'defaultTaxRate' => $defaultTaxRate,
            'countryId' => $countryId,
            'shippingType' => $shippingType ? $shippingType : null
        ];

        $cart = new Cart($params);

        $cartItemFactory = new CartItemFactory($this->cartRepository, $cart);
        foreach ($cartItemFactory->makeFromIds($items, $priceIncludesTax, $cart->getDefaultTaxRate()) as $item)
        {
            $cart->add($item);
        }

        $cart->checkIdList();

        // check for free shipping
        if (isset($clientInfo->business_settings->free_shipping) && $clientInfo->business_settings->free_shipping->free_shipping_enabled)
        {
            $cart->updateForFreeShipping($this->cartValuesTransformer, $clientInfo->business_settings->free_shipping->free_shipping_minimum_order, $clientInfo->business_settings->free_shipping->free_shipping_countries);
        }

        return $cart;
    }

}