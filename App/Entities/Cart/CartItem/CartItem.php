<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem;

use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;

class CartItem {

    /**
     * @var string
     */
    private $productVariationId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $taxRate;

    /**
     * @var object
     */
    private $productVariation;

    /**
     * @var object
     */
    private $product;

    /**
     * @var int
     */
    private $basePrice;
    
    /**
     * @var int
     */
    private $shippingPrice;

    /**
     * @var int
     */
    private $shippingTaxRate;

    /**
     * @var bool
     */
    private $priceIncludesTax;

    /**
     * CartItem constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->productVariationId = $params['productVariationId'];
        $this->quantity = $params['quantity'];
        $this->taxRate = $params['taxRate'];
        $this->productVariation = $params['productVariation'];
        $this->product = $params['product'];
        $this->basePrice = $params['basePrice'];
        $this->shippingPrice = $params['shippingPrice'];
        $this->shippingTaxRate = $params['shippingTaxRate'];
        $this->priceIncludesTax = $params['priceIncludesTax'];
    }

    /**
     * @return object
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return object
     */
    public function getProductVariation()
    {
        return $this->productVariation;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * Note: if there is more than one item, we need to split the amounts carefully
     *    so we don't lose any pennies here and there
     * @param int $count
     * @return int
     */
    public function getSingleItemPrice($count = 1)
    {
        if (!$this->priceIncludesTax) return $this->basePrice;

        $totalWithoutTax = $this->totalBeforeTax();
        $singleItemPrice = (int)($totalWithoutTax / $this->quantity);
        if ($count == $this->quantity) $singleItemPrice += $totalWithoutTax % $this->quantity;

        return $singleItemPrice;
    }

    /**
     * including price, tax and shipping
     * @return int
     */
    public function total()
    {
        return $this->totalBeforeTax() + $this->taxWithoutShipping() + $this->shipping();
    }

    /**
     * including price and tax
     * @return int
     */
    public function totalWithoutShipping()
    {
        $total = $this->quantity * $this->basePrice;
        return $this->priceIncludesTax ? $total :  $total + $this->taxWithoutShipping();
    }

    /**
     * price before tax and without shipping
     * @return int
     */
    public function totalBeforeTax()
    {
        $total = $this->basePrice * $this->quantity;
        return $this->priceIncludesTax ? $total - $this->taxWithoutShipping() : $total;
    }

    /**
     * just price without shipping or tax
     * @return int
     */
    public function displayTotal()
    {
        return $this->quantity * $this->basePrice;
    }

    /**
     * total shipping including tax
     * @return int
     */
    public function shipping()
    {
        if ($this->shippingPrice === null) return null;
        return $this->shippingBeforeTax() + $this->shippingTax();
    }

    /**
     * total shipping before tax
     * @return int
     */
    public function shippingBeforeTax()
    {
        if ($this->shippingPrice === null) return null;
        return $this->priceIncludesTax ? ($this->shippingPrice * $this->quantity) - $this->shippingTax() : $this->shippingPrice * $this->quantity;
    }

    /**
     * @return int
     */
    public function shippingTax()
    {
        if ($this->shippingPrice === null) return null;
        return $this->priceIncludesTax ? TaxCalculator::taxFromTotal($this->shippingPrice, $this->taxRate, $this->quantity) : (int)($this->shippingPrice / 100 * $this->taxRate) * $this->quantity;
    }

    /**
     * shipping display value
     * @return int
     */
    public function displayShipping()
    {
        if ($this->shippingPrice === null) return null;
        return $this->shippingPrice * $this->quantity;
    }

    /**
     * total amount of tax including shipping tax
     * @return int
     */
    public function tax()
    {
        $tax = $this->priceIncludesTax ? TaxCalculator::taxFromTotal($this->basePrice, $this->taxRate, $this->quantity) : ($this->basePrice * $this->quantity / 100 * $this->taxRate);
        return $tax + $this->shippingTax();
    }

    /**
     * total amount of tax excluding shipping tax
     * @return int
     */
    public function taxWithoutShipping()
    {
        return $this->tax() - $this->shippingTax();
    }
}