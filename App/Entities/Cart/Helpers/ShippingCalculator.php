<?php namespace AlistairShaw\Vendirun\App\Entities\Cart\Helpers;

class ShippingCalculator {

    /**
     * @param object $shipping
     * @param int    $quantity
     * @param int    $countryId
     * @param string $shippingType
     * @return int|null
     */
    public static function shippingForItem($shipping, $quantity = 1, $countryId = NULL, $shippingType = '')
    {
        $hasPrices = false;
        $price = NULL;

        foreach ($shipping as $sh)
        {
            if (in_array($countryId, $sh->countries))
            {
                $hasPrices = true;
                if (!$shippingType) $shippingType = $sh->shipping_type;

                if ($shippingType && $shippingType == $sh->shipping_type)
                {
                    $price = $sh->product_price;
                }
            }
        }

        if ($hasPrices && $price === NULL && $shippingType)
        {
            return self::shippingForItem($shipping, $quantity, $countryId, '');
        }

        if ($price !== NULL) $price *= $quantity;

        return $price;
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
            foreach ($product->shipping as $sh)
            {
                if (in_array($countryId, $sh->countries))
                {
                    $productShippingTypes[] = $sh->shipping_type;
                }
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
        $shippingCharge = 0;

        foreach ($products as $product)
        {
            foreach ($product->shipping as $sh)
            {
                if (in_array($countryId, $sh->countries))
                {
                    if ($shippingType && $shippingType == $sh->shipping_type)
                    {
                        if ($sh->order_price > $shippingCharge) $shippingCharge = $sh->order_price;
                    }
                }
            }
        }

        return $shippingCharge;
    }
}