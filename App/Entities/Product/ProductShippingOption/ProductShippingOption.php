<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption;

class ProductShippingOption {

    /**
     * @var int
     */
    private $orderPrice;

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
     * ProductShippingOption constructor.
     * @param       $orderPrice
     * @param       $shippingType
     * @param array $countryIds
     * @param null  $weightFrom
     * @param null  $weightTo
     */
    public function __construct($orderPrice, $shippingType, $countryIds = [], $weightFrom = null, $weightTo = null)
    {
        $this->orderPrice = $orderPrice;
        $this->shippingType = $shippingType;
        $this->countryIds = $countryIds;
        $this->weightFrom = $weightFrom;
        $this->weightTo = $weightTo;
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

}