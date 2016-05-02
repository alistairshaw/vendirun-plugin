<?php namespace AlistairShaw\Vendirun\App\Entities\Order\OrderItem;

class OrderItem {

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $productVariationId;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var string
     */
    private $productSku;

    /**
     * @var int
     */
    private $price;

    /**
     * @var float
     */
    private $taxRate;

    /**
     * @var bool
     */
    private $isShipping;

    /**
     * @var int
     */
    private $discount;

    /**
     * OrderItem constructor.
     * @param        $id
     * @param        $productVariationId
     * @param        $taxRate
     * @param        $price
     * @param string $productName
     * @param string $productSku
     * @param int    $isShipping
     * @param int    $discount
     */
    public function __construct($id, $productVariationId, $taxRate, $price, $productName = '', $productSku = '', $isShipping = 0, $discount = 0)
    {
        $this->id = $id;
        $this->taxRate = $taxRate;
        $this->price = $price;
        $this->productName = $productName;
        $this->productSku = $productSku;
        $this->isShipping = $isShipping;
        $this->discount = $discount;
        $this->productVariationId = $productVariationId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProductVariationId()
    {
        return $this->productVariationId;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @return string
     */
    public function getProductSku()
    {
        return $this->productSku;
    }

    /**
     * @return boolean
     */
    public function isShipping()
    {
        return $this->isShipping;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

}