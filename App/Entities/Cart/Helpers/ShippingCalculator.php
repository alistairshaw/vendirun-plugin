<?php

namespace AlistairShaw\Vendirun\App\Entities\Cart\Helpers;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption\ProductShippingOption;

class ShippingCalculator
{

    /**
     * @param array $shipping
     * @param int $quantity
     * @param int $countryId
     * @param string $shippingType
     * @return int|null
     */
    public static function shippingForItem($shipping, $quantity = 1, $countryId = NULL, $shippingType = '')
    {
        $price = NULL;

        foreach ($shipping as $sh)
        {
            /* @var $sh ProductShippingOption */
            if ($price = $sh->getUnitMatch($countryId, $shippingType)) return $price;
        }

        if (!$price && $shippingType)
        {
            return self::shippingForItem($shipping, $quantity, $countryId, '');
        }

        if ($price === false) return null;

        return $price * $quantity;
    }

    /**
     * @param Cart $cart
     * @return array
     */
    public static function availableShippingTypes(Cart $cart)
    {
        $availableShippingTypes = [];
        $first = true;

        foreach ($cart->getItems() as $cartItem)
        {
            /* @var $cartItem CartItem */
            $product = $cartItem->getProduct();

            /* @var $product Product */
            $productShippingTypes = [];
            if ($product->getShipping())
            {
                foreach ($product->getShipping() as $sh)
                {
                    /* @var $sh ProductShippingOption */
                    if ($shippingType = $sh->matchShippingType($cart->getCountryId())) $productShippingTypes[] = $shippingType;
                }

                if (!$first)
                {
                    // if there are any available ones that aren't available for this product, remove them
                    $newAvailable = [];
                    foreach ($productShippingTypes as $type)
                    {
                        if (in_array($type, $availableShippingTypes)) $newAvailable[] = $type;
                    }
                    $availableShippingTypes = $newAvailable;
                }
                else
                {
                    $first = false;
                    $availableShippingTypes = $productShippingTypes;
                }
            }
        }

        return $availableShippingTypes;
    }

    /**
     * @param        $products
     * @param null $countryId
     * @param string $shippingType
     * @return array
     */
    public static function orderShippingCharge($products, $countryId = NULL, $shippingType = '')
    {
        $shippingCharge = null;

        $suppliers = [];

        foreach ($products as $product)
        {
            /* @var $product Product */
            if ($product->getShipping())
            {
                foreach ($product->getShipping() as $sh)
                {
                    /* @var $sh ProductShippingOption */
                    if ($sh->getMatch($countryId, $shippingType))
                    {
                        if ($sh->getSupplierId())
                        {
                            $suppliers[$sh->getSupplierId()] = $sh->getOrderPrice();
                        }
                        else
                        {
                            $suppliers[0] = $sh->getOrderPrice();
                        }
                        continue;
                    }
                }
            }
        }

        $shippingCharge = false;
        foreach ($suppliers as $supplierId => $value)
        {
            $shippingCharge += $value;
        }

        // return null if no shipping charge applies
        return $shippingCharge !== false ? $shippingCharge : NULL;
    }
}