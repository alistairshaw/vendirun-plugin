<?php

namespace AlistairShaw\Vendirun\App\Entities\Cart\Helpers;

use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption\ProductShippingOption;

class ShippingCalculator {

    /**
     * @param array $shipping
     * @param int    $quantity
     * @param int    $countryId
     * @param string $shippingType
     * @return int|null
     */
    public static function shippingForItem($shipping, $quantity = 1, $countryId = NULL, $shippingType = '')
    {
        $price = NULL;

        foreach ($shipping as $sh)
        {
            /* @var $sh ProductShippingOption */
            $price = $sh->getMatch($countryId, $shippingType);
        }

        if (!$price && $shippingType)
        {
            return self::shippingForItem($shipping, $quantity, $countryId, '');
        }

        if ($price === false) return 0;

        return $price * $quantity;
    }

    /**
     * @param      $products
     * @param null $countryId
     * @return array
     */
    public static function availableShippingTypes($products, $countryId = NULL)
    {
        $availableShippingTypes = [];
        $first = true;

        foreach ($products as $product)
        {
            $productShippingTypes = [];
            /* @var $product Product */
            foreach ($product->getShipping() as $sh)
            {
                /* @var $sh ProductShippingOption */
                if ($shippingType = $sh->matchShippingType($countryId)) $productShippingTypes[] = $shippingType;
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

        return $availableShippingTypes;
    }

    /**
     * @param        $products
     * @param null   $countryId
     * @param string $shippingType
     * @return array
     */
    public static function orderShippingCharge($products, $countryId = NULL, $shippingType = '')
    {
        $shippingCharge = null;

        foreach ($products as $product)
        {
            /* @var $product Product */
            foreach ($product->getShipping() as $sh)
            {
                /* @var $sh ProductShippingOption */
                if ($shippingCharge = $sh->getMatch($countryId, $shippingType)) return $shippingCharge;
            }
        }

        // return null if no shipping charge applies
        return $shippingCharge !== false ? $shippingCharge : NULL;
    }
}