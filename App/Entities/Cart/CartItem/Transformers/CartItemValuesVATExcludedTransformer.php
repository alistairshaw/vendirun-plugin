<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem\Transformers;

use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;

class CartItemValuesVATExcludedTransformer implements CartItemValuesTransformer {

    /**
     * @param $quantity
     * @param $taxRate
     * @param $basePrice
     * @param $shippingPrice
     * @return array
     */
    public function getValues($quantity, $taxRate, $basePrice, $shippingPrice)
    {
        $subTotal = $quantity * $basePrice;
        $tax = TaxCalculator::totalPlusTax($basePrice, $taxRate, $quantity);

        return [
            'total' => $subTotal,
            'shipping' => $shippingPrice,
            'tax' => $tax,
        ];
    }
}