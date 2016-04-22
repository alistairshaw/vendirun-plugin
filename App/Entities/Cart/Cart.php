<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;

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
     * @var string
     */
    private $shippingType;

    /**
     * @var array
     */
    private $availableShippingTypes;

    /**
     * Cart constructor.
     * @param array          $params | ids,items,countryId,priceIncludesTax,chargeTaxOnShipping,defaultTaxRate,shipping,shippingType,availableShippingTypes
     */
    public function __construct($params)
    {
        $this->ids = $params['ids'];
        $this->items = $params['items'];
        $this->countryId = $params['countryId'];
        $this->priceIncludesTax = $params['priceIncludesTax'];
        $this->chargeTaxOnShipping = $params['chargeTaxOnShipping'];
        $this->defaultTaxRate = $params['defaultTaxRate'];
        $this->orderShippingPrice = $params['orderShippingPrice'];
        $this->shippingType = $params['shippingType'];
        $this->availableShippingTypes = $params['availableShippingTypes'];
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->items ? count($this->items) : 0;
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
     * @return bool|mixed
     */
    public function getPriceIncludesTax()
    {
        return $this->priceIncludesTax;
    }

    /**
     * @return int
     */
    public function totalProducts()
    {
        return count($this->ids);
    }

    /**
     * including price, tax and shipping
     * @return int
     */
    public function total()
    {
        return $this->sum('total') + $this->orderShippingBeforeTax() + $this->orderShippingTax();
    }

    /**
     * including price and tax
     * @return int
     */
    public function totalWithoutShipping()
    {
        return $this->sum('totalWithoutShipping');
    }

    /**
     * price before tax and without shipping
     * @return int
     */
    public function totalBeforeTax()
    {
        return $this->sum('totalBeforeTax');
    }

    /**
     * just price without shipping or tax
     * @return int
     */
    public function displayTotal()
    {
        return $this->sum('displayTotal');
    }

    /**
     * order shipping only
     * @return int
     */
    public function displayOrderShipping()
    {
        if ($this->orderShippingPrice === null) return null;
        return $this->orderShippingPrice;
    }

    /**
     * order shipping before tax (not including individual products)
     * @return int
     */
    public function orderShippingBeforeTax()
    {
        if ($this->orderShippingPrice === null) return null;
        return $this->priceIncludesTax ? $this->orderShippingPrice - TaxCalculator::taxFromTotal($this->orderShippingPrice, $this->defaultTaxRate) : $this->orderShippingPrice;
    }

    /**
     * order shipping tax amount (not including individual products)
     * @return int
     */
    public function orderShippingTax()
    {
        if ($this->orderShippingPrice === null) return null;
        return $this->priceIncludesTax ? TaxCalculator::taxFromTotal($this->orderShippingPrice, $this->defaultTaxRate) : TaxCalculator::totalPlusTax($this->orderShippingPrice, $this->defaultTaxRate);
    }

    /**
     * total shipping including tax
     * @return int
     */
    public function shipping()
    {
        if ($this->orderShippingPrice === null) return null;
        return $this->sum('shipping') + $this->orderShippingBeforeTax() + $this->orderShippingTax();
    }

    /**
     * total shipping before tax
     * @return int
     */
    public function shippingBeforeTax()
    {
        if ($this->orderShippingPrice === null) return null;
        return $this->sum('shippingBeforeTax') + $this->orderShippingBeforeTax();
    }

    /**
     * @return int
     */
    public function shippingTax()
    {
        if ($this->orderShippingPrice === null) return null;
        return $this->sum('shippingTax') + $this->orderShippingTax();
    }

    /**
     * shipping display value
     * @return int
     */
    public function displayShipping()
    {
        if ($this->orderShippingPrice === null) return null;
        return $this->sum('displayShipping') + $this->orderShippingPrice;
    }

    /**
     * total amount of tax including shipping tax
     * @return int
     */
    public function tax()
    {
        return $this->sum('tax') + $this->orderShippingTax();
    }

    /**
     * total amount of tax excluding shipping tax
     * @return int
     */
    public function taxWithoutShipping()
    {
        return $this->sum('taxWithoutShipping');
    }

    /**
     * @return object
     */
    public function getFormattedTotals()
    {
        return (object)[
            'displayTotal' => CurrencyHelper::formatWithCurrency($this->displayTotal()),
            'tax' => CurrencyHelper::formatWithCurrency($this->tax()),
            'displayShipping' => $this->displayShipping() === null ? 'NOT AVAILABLE' : CurrencyHelper::formatWithCurrency($this->displayShipping()),
            'total' => CurrencyHelper::formatWithCurrency($this->total()),
            'totalBeforeTax' => CurrencyHelper::formatWithCurrency($this->totalBeforeTax()),
            'shippingBeforeTax' => $this->displayShipping() === null ? 'NOT AVAILABLE' : CurrencyHelper::formatWithCurrency($this->shippingBeforeTax())
        ];
    }

    /**
     * @param $cartItemFunctionName
     * @return int
     */
    private function sum($cartItemFunctionName)
    {
        $total = 0;
        foreach ($this->items as $cartItem)
        {
            //var_dump($cartItem->{$cartItemFunctionName}());
            if ($cartItem->{$cartItemFunctionName}() === null)
            {
                $total = null;
            }
            else
            {
                $total += $cartItem->{$cartItemFunctionName}();
            }
        }
        return $total;
    }

}