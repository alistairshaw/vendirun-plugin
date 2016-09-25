<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\Transformers;

interface CartValuesTransformer {

    /**
     * @param $orderShippingPrice
     * @param $chargeTaxOnShipping
     * @param $freeShipping
     * @param $defaultTaxRate
     * @param $items
     * @return mixed
     */
    public function getValues($orderShippingPrice, $chargeTaxOnShipping, $freeShipping, $defaultTaxRate, $items);

}