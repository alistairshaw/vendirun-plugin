<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\Transformers;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\Transformers\CartItemValuesVATExcludedTransformer;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;

class CartValuesVATExcludedTransformer implements CartValuesTransformer {

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

        // add up values for each item
        foreach ($items as $cartItem)
        {
            /* @var $cartItem CartItem */
            $cartItemTotals = $cartItem->getValues(new CartItemValuesVATExcludedTransformer());
            $subTotal += $cartItemTotals['total'];
            $shipping += $cartItemTotals['shipping'];
            $tax += $cartItemTotals['tax'];
        }

        // calculate tax on shipping
        $tax += TaxCalculator::totalPlusTax($shipping, $defaultTaxRate, 1);

        return [
            'subTotal' => $subTotal,
            'displayTotal' => $subTotal,
            'shipping' => $shipping,
            'displayShipping' => $shipping,
            'tax' => $tax,
            'total' => $subTotal + $shipping + $tax
        ];
    }

}