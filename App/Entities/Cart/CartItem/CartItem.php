<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\Transformers\CartItemValuesTransformer;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Entities\Product\ProductVariation\ProductVariation;

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

        if (isset($params['shippingPrice'])) $this->shippingPrice = $params['shippingPrice'];
        if (isset($params['countryId'])) $this->countryId = $params['countryId'];
        if (isset($params['shippingType'])) $this->shippingType = $params['shippingType'];

        $this->updateShippingAndTaxes();
    }

    /**
     * @param CartItemValuesTransformer $transformer
     * @return array
     */
    public function getValues(CartItemValuesTransformer $transformer)
    {
        return $transformer->getValues($this->quantity, $this->taxRate, $this->basePrice, $this->shippingPrice);
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
     * @param string $shippingType
     * @return $this
     */
    public function freeShipping($shippingType = '')
    {
        $this->shippingPrice = 0;
        $this->shippingType = $shippingType;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->basePrice;
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
     * @return string
     */
    public function getSku()
    {
        return $this->getThisVariation()->getSku();
    }

    /**
     * @return mixed
     */
    public function getVariationId()
    {
        return $this->productVariationId;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->product->getProductName() . ' ' . $this->getThisVariation()->getName();
    }

    /**
     * @param     $countryId
     * @param int $default
     */
    public function setTaxPrice($countryId, $default = 0)
    {
        $this->taxRate = TaxCalculator::calculateProductTaxRate($this->product->getTax(), $countryId, $default);
    }

    /**
     * @return ProductVariation
     */
    private function getThisVariation()
    {
        $variations = $this->product->getVariations();
        return $variations[0];
    }

    /**
     * @return bool
     */
    public function shippingApplies()
    {
        switch ($this->product->getProductType())
        {
            case 'Virtual':
            case 'Downloadable':
                return false;
            default:
                return true;
        }
    }
}