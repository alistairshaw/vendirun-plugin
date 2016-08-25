<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption;

class ProductShippingOption {

    /**
     * @var int
     */
    private $orderPrice;

    /**
     * @var int
     */
    private $itemPrice;

    /**
     * @var string
     */
    private $shippingType;

    /**
     * @var int
     */
    private $weightFrom;

    /**
     * @var int
     */
    private $weightTo;

    /**
     * @var array
     */
    private $countryIds;

    /**
     * @var null
     */
    private $supplierId;

    /**
     * ProductShippingOption constructor.
     * @param       $orderPrice
     * @param       $itemPrice
     * @param       $shippingType
     * @param null $supplierId
     * @param array $countryIds
     * @param null $weightFrom
     * @param null $weightTo
     */
    public function __construct($orderPrice, $itemPrice, $shippingType, $supplierId = null, $countryIds = [], $weightFrom = null, $weightTo = null)
    {
        $this->orderPrice = (int)$orderPrice;
        $this->itemPrice = (int)$itemPrice;
        $this->shippingType = $shippingType;
        $this->supplierId = (int)$supplierId;
        $this->countryIds = $countryIds;
        $this->weightFrom = (int)$weightFrom;
        $this->weightTo = (int)$weightTo;
    }

    /**
     * @param $countryId
     * @param $shippingType
     * @return bool|int
     */
    public function getMatch($countryId, $shippingType)
    {
        return (in_array($countryId, $this->countryIds) && $shippingType == $this->shippingType) ? $this->orderPrice : false;
    }

    /**
     * @param $countryId
     * @return bool|int
     */
    public function matchShippingType($countryId)
    {
        return (in_array($countryId, $this->countryIds)) ? $this->shippingType : false;
    }

    /**
     * @return int
     */
    public function getOrderPrice()
    {
        return $this->orderPrice;
    }

    /**
     * @return int
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

}