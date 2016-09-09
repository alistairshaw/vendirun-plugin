<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption;

class ProductTaxOptionFactory {

    /**
     * @param $apiTax
     * @return array
     */
    public static function makeFromApi($apiTax)
    {
        $tax = [];
        foreach ($apiTax as $item)
        {
            $tax[] = new ProductTaxOption($item->percentage, $item->countries, !$item->id);
        }
        return $tax;
    }

}