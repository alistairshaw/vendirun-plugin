<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption;

class ProductTaxOption {

    /**
     * @var bool
     */
    private $isDefault;

    /**
     * @var float
     */
    private $percentage;

    /**
     * @var array
     */
    private $countryIds;

    /**
     * ProductTaxOption constructor.
     * @param       $percentage
     * @param array $countryIds
     * @param       $isDefault
     */
    public function __construct($percentage, $countryIds, $isDefault)
    {
        $this->percentage = (float)$percentage;
        $this->countryIds = $countryIds;
        $this->isDefault = (bool)$isDefault;
    }

    /**
     * @param $countryId
     * @return bool|int
     */
    public function getMatch($countryId)
    {
        return (in_array($countryId, $this->countryIds)) ? $this->percentage : 0;
    }

    /**
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->isDefault;
    }

}