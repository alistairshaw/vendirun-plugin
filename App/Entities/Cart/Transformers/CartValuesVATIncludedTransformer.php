<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\Transformers;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\Transformers\CartItemValuesVATIncludedTransformer;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;

class CartValuesVATIncludedTransformer implements CartValuesTransformer {

    /**
     * @param $orderShippingPrice
     * @param $chargeTaxOnShipping
     * @param $freeShipping
     * @param $defaultTaxRate
     * @param $items
     * @return mixed
     */
    public function getValues($orderShippingPrice, $chargeTaxOnShipping, $freeShipping, $defaultTaxRate, $items)
    {
        $subTotal = 0;
        $shipping = $orderShippingPrice;
        $tax = 0;

        foreach ($items as $cartItem)
        {
            /* @var $cartItem CartItem */
            $cartItemTotals = $cartItem->getValues(new CartItemValuesVATIncludedTransformer());
            $subTotal += $cartItemTotals['total'];
            $shipping += $cartItemTotals['shipping'];
            $tax += $cartItemTotals['tax'];
        }

        // calculate tax on shipping
        $shippingTax = TaxCalculator::taxFromTotal($shipping, $defaultTaxRate, 1);

        return [
            'subTotal' => $subTotal + $tax,
            'displayTotal' => $subTotal,
            'shipping' => $shipping + $shippingTax,
            'displayShipping' => $shipping,
            'tax' => $tax,
            'total' => $subTotal + $tax + $shipping + $shippingTax
        ];
    }

}