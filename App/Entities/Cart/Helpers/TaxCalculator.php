<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\Helpers;

class TaxCalculator {

    /**
     * @param     $tax
     * @param     $countryId
     * @param int $default
     * @return int
     */
    public static function calculateProductTaxRate($tax, $countryId = NULL, $default = 0)
    {
        foreach ($tax as $row)
        {
            if (!$countryId && !$row->id) return (float)$row->percentage;
            if (in_array($countryId, (array)$row->countries)) return (float)$row->percentage;
            if ($row->id === NULL) $default = (float)$row->percentage;
        }
        return $default;
    }

    /**
     * @param $tax
     * @param $countryId
     * @param $price
     * @param $quantity
     * @return int
     */
    public static function calculateItemTax($tax, $countryId, $price, $quantity)
    {
        $taxRate = self::calculateProductTaxRate($tax, $countryId);

        if (self::pricesIncludeTax($tax, $countryId))
        {
            return self::taxFromTotal($price, $taxRate, $quantity);
        }
        else
        {
            return self::totalPlusTax($price, $taxRate, $quantity);
        }
    }

    /**
     * @param      $tax
     * @param int  $countryId
     * @return bool
     */
    private static function pricesIncludeTax($tax, $countryId = NULL)
    {
        $default = true;
        foreach ($tax as $row)
        {
            if (!$countryId && !$row->id) return (bool)$row->price_includes_tax;
            if (in_array($countryId, (array)$row->countries)) return (bool)$row->price_includes_tax;
            if ($row->id === NULL) $default = (float)$row->price_includes_tax;
        }
        return $default;
    }

    /**
     * @param     $amount
     * @param     $taxRate
     * @param int $quantity
     * @return int
     */
    public static function taxFromTotal($amount, $taxRate, $quantity = 1)
    {
        $itemSubTotal = (int)(round(($amount * $quantity * 100 / ($taxRate + 100)), 0, PHP_ROUND_HALF_UP));
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
        return (int)(round(($amount * $quantity * $taxRate / 100), 0));
    }

}