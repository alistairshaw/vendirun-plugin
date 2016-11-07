<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem\Transformers;

interface CartItemValuesTransformer {

    /**
     * @param $quantity
     * @param $taxRate
     * @param $basePrice
     * @param $shippingPrice
     * @return array
     */
    public function getValues($quantity, $taxRate, $basePrice, $shippingPrice);

}