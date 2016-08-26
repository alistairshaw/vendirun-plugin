<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem;

use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Product\Product;

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
     * @var Product
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
     * @var int
     */
    private $countryId;

    /**
     * @var string
     */
    private $shippingType;

    /**
     * CartItem constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->productVariationId = $params['productVariationId'];
        $this->quantity = $params['quantity'];
        $this->product = $params['product'];
        $this->basePrice = $params['basePrice'];

        if (isset($params['taxRate'])) $this->taxRate = $params['taxRate'];
        if (isset($params['shippingPrice'])) $this->shippingPrice = $params['shippingPrice'];
        if (isset($params['shippingTaxRate'])) $this->shippingTaxRate = $params['shippingTaxRate'];
        if (isset($params['countryId'])) $this->countryId = $params['countryId'];
        if (isset($params['shippingType'])) $this->shippingType = $params['shippingType'];
        $this->priceIncludesTax = (isset($params['priceIncludesTax'])) ? $params['priceIncludesTax'] : true;

        $this->updateShippingAndTaxes();
    }

    /**
     * @param $countryId
     */
    public function setCountryId($countryId)
    {
        $this->countryId = (int)$countryId;
        $this->updateShippingAndTaxes();
    }

    /**
     * @param $shippingType
     */
    public function setShippingType($shippingType)
    {
        $this->shippingType = $shippingType ? $shippingType : null;
        $this->updateShippingAndTaxes();
    }

    /**
     *
     */
    private function updateShippingAndTaxes()
    {
        $this->taxRate = TaxCalculator::calculateProductTaxRate($this->getProduct()->getTax(), $this->countryId);
        $this->shippingPrice = ShippingCalculator::shippingForItem($this->getProduct()->getShipping(), $this->getQuantity(), $this->countryId, $this->shippingType);
    }

    /**
     * @return array
     */
    public function display()
    {
        return [
            'productVariationId' => $this->productVariationId,
            'quantity' => $this->quantity,
            'taxRate' => $this->taxRate,
            'product' => $this->product->getDisplayArray()
        ];
    }

    /**
     * @return object
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return array
     */
    public function getShipping()
    {
        return $this->product->getShipping();
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param int $quantity
     * @return bool | TRUE if it's the last item
     */
    public function remove($quantity = 1)
    {
        $this->quantity = $this->quantity - $quantity;
        if ($this->quantity <= 0) return true;

        return false;
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
        $total = $this->totalBeforeTax() + $this->taxWithoutShipping() + $this->shipping();
        return $total;
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
     * @return int
     */
    public function rawShipping()
    {
        return $this->shippingPrice;
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

    /**
     * @return string
     */
    public function getSku()
    {
        $variations = $this->product->getVariations();
        return $variations[0]->getSku();
    }

    /**
     * @return mixed
     */
    public function getVariationId()
    {
        $variations = $this->product->getVariations();
        return $variations[0]->getId();
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        $variations = $this->product->getVariations();
        return $this->product->getProductName() . ' ' . $variations[0]->getName();
    }

    /**
     * @param     $countryId
     * @param int $default
     */
    public function setTaxPrice($countryId, $default = 0)
    {
        $this->taxRate = TaxCalculator::calculateProductTaxRate($this->product->getTax(), $countryId, $default);
    }
}