<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\Helpers;

use AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption\ProductTaxOption;

class TaxCalculator {

    /**
     * @param array            $tax
     * @param                  $countryId
     * @param int              $default
     * @return int
     */
    public static function calculateProductTaxRate($tax, $countryId = NULL, $default = 0)
    {
        if (!$tax) return $default;

        $percentage = NULL;
        foreach ($tax as $taxOption)
        {
            /* @var $taxOption ProductTaxOption */
            if (!$countryId && $taxOption->isDefault()) $percentage = $taxOption->getPercentage();
            if ($taxOption->getMatch($countryId)) $percentage = $taxOption->getPercentage();
            if ($taxOption->isDefault() && $percentage === NULL) $percentage = $taxOption->getPercentage();
        }

        if ($percentage === NULL && $default) $percentage = $default;

        return $percentage;
    }

    /**
     * @param     $amount
     * @param     $taxRate
     * @param int $quantity
     * @return int
     */
    public static function taxFromTotal($amount, $taxRate, $quantity = 1)
    {
        $itemSubTotal = (int)(round(($amount * $quantity * 100 / ($taxRate + 100)), 0, PHP_ROUND_HALF_DOWN));

        return ($amount * $quantity) - $itemSubTotal;
    }

    /**
     * @param     $amount
     * @param     $taxRate
     * @param int $quantity
     * @return int
     */
    public static function totalPlusTax($amount, $taxRate, $quantity = 1)
    {
        return (int)(round(($amount * $quantity * $taxRate / 100), 0, PHP_ROUND_HALF_DOWN));
    }

}