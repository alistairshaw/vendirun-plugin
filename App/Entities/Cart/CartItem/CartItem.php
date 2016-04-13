<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem;

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
     * @var float
     */
    private $itemTax;
    
    /**
     * @var int
     */
    private $shippingPrice;

    /**
     * @var int
     */
    private $shippingTax;

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
        $this->itemTax = $params['itemTax'];
        $this->shippingPrice = $params['shippingPrice'];
        $this->shippingTax = $params['shippingTax'];
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
     * @return int
     */
    public function displayPrice()
    {
        return $this->priceIncludesTax ? $this->basePrice + $this->itemTax : $this->basePrice;
    }

    /**
     * @return int
     */
    public function displayShipping()
    {
        return $this->priceIncludesTax ? $this->shippingPrice + $this->shippingTax : $this->shippingPrice;
    }

    /**
     * @return int
     */
    public function total()
    {
        return $this->basePrice + $this->itemTax + $this->shippingPrice + $this->shippingTax;
    }

    /**
     * @return int
     */
    public function basePrice()
    {
        return $this->basePrice;
    }

    /**
     * @return int
     */
    public function singleItemPrice()
    {
        return (int)round($this->basePrice / $this->quantity, 0);
    }

    /**
     * @return float
     */
    public function tax()
    {
        return $this->itemTax;
    }

    /**
     * @return int
     */
    public function shipping()
    {
        return $this->shippingPrice;
    }

    /**
     * @return int
     */
    public function shippingTax()
    {
        return $this->shippingTax;
    }
}