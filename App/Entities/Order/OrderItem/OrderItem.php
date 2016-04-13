<?php namespace AlistairShaw\Vendirun\App\Entities\Order\OrderItem;

class OrderItem {

    /**
     * @var string
     */
    private $id;

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
     * @param        $taxRate
     * @param        $price
     * @param string $productName
     * @param string $productSku
     * @param int    $isShipping
     */
    public function __construct($id, $taxRate, $price, $productName = '', $productSku = '', $isShipping = 0, $discount = 0)
    {
        $this->id = $id;
        $this->taxRate = $taxRate;
        $this->price = $price;
        $this->productName = $productName;
        $this->productSku = $productSku;
        $this->isShipping = $isShipping;
        $this->discount = $discount;
    }

}