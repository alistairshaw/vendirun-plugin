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
    public function getProductVariationId()
    {
        return $this->productVariationId;
    }

    /**
     * @return int
     */
    public function getItemTotal()
    {
        return $this->price + (int)($this->price / 100 * $this->taxRate);
    }
}