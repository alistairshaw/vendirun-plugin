<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\CartItem\Transformers;

use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;

class CartItemValuesVATIncludedTransformer implements CartItemValuesTransformer {

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
        $tax = TaxCalculator::taxFromTotal($basePrice, $taxRate, $quantity);
        $shippingTotal = $shippingPrice === null ? null : $shippingPrice * $quantity;

        return [
            'total' => $subTotal,
            'shipping' => $shippingTotal,
            'tax' => $tax,
            'shippingBeforeTax' => $shippingTotal - TaxCalculator::taxFromTotal($shippingTotal, $taxRate),
            'totalBeforeTax' => $subTotal - TaxCalculator::taxFromTotal($subTotal, $taxRate),
        ];
    }
}