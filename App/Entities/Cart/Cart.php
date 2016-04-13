<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;

class Cart {

    /**
     * @var array
     */
    private $ids;

    /**
     * @var array
     */
    private $items;

    /**
     * @var int
     */
    private $countryId;

    /**
     * @var bool
     */
    private $priceIncludesTax;

    /**
     * @var bool
     */
    private $chargeTaxOnShipping;

    /**
     * @var float
     */
    private $defaultTaxRate;

    /**
     * @var int
     */
    private $orderShippingPrice;

    /**
     * @var int
     */
    private $orderShippingTax;

    /**
     * @var string
     */
    private $shippingType;

    /**
     * @var array
     */
    private $availableShippingTypes;

    /**
     * Cart constructor.
     * @param CartRepository $cartRepository
     * @param array          $params | ids,items,countryId,priceIncludesTax,chargeTaxOnShipping,defaultTaxRate,shipping,shippingType,availableShippingTypes
     */
    public function __construct(CartRepository $cartRepository, $params)
    {
        $this->ids = $params['ids'];
        $this->items = $params['items'];
        $this->countryId = $params['countryId'];
        $this->priceIncludesTax = $params['priceIncludesTax'];
        $this->chargeTaxOnShipping = $params['chargeTaxOnShipping'];
        $this->defaultTaxRate = $params['defaultTaxRate'];
        $this->orderShippingPrice = $params['orderShippingPrice'];
        $this->orderShippingTax = $params['orderShippingTax'];
        $this->shippingType = $params['shippingType'];
        $this->availableShippingTypes = $params['availableShippingTypes'];
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @return float
     */
    public function getDefaultTaxRate()
    {
        return $this->defaultTaxRate;
    }

    /**
     * @return array
     */
    public function getAvailableShippingTypes()
    {
        return $this->availableShippingTypes;
    }

    /**
     * @return string
     */
    public function getShippingType()
    {
        return $this->shippingType;
    }

    /**
     * @return int
     */
    public function totalProducts()
    {
        return count($this->ids);
    }

    /**
     * @return int
     */
    public function displayPrice()
    {
        return $this->sum('displayPrice');
    }

    /**
     * @return int
     */
    public function displayShipping()
    {
        return $this->sum('displayShipping') + $this->orderShippingPrice + $this->orderShippingTax;
    }

    /**
     * @return int
     */
    public function total()
    {
        return $this->shipping() + $this->subTotal() + $this->tax();
    }

    /**
     * @return int
     */
    public function shipping()
    {
        if (!$this->shippingType || !$this->countryId) return null;
        return $this->sum('shipping') + $this->orderShippingPrice;
    }

    /**
     * @return int
     */
    public function subTotal()
    {
        return $this->sum('basePrice');
    }

    /**
     * @return int
     */
    public function tax()
    {
        return $this->sum('tax') + $this->shippingTax();
    }

    /**
     * @return int
     */
    public function shippingTax()
    {
        if (!$this->chargeTaxOnShipping) return 0;
        return $this->sum('shippingTax') + $this->orderShippingTax;
    }

    /**
     * @return boolean
     */
    public function priceIncludesTax()
    {
        return $this->priceIncludesTax;
    }

    /**
     * @param $cartItemFunctionName
     * @return int|mixed
     */
    private function sum($cartItemFunctionName)
    {
        $total = 0;
        foreach ($this->items as $cartItem)
        {
            $total += $cartItem->{$cartItemFunctionName}();
        }
        return $total;
    }

}