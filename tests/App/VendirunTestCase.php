<?php namespace AlistairShaw\Vendirun\Tests\App;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption\ProductShippingOption;
use AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption\ProductTaxOption;
use AlistairShaw\Vendirun\App\Entities\Product\ProductVariation\ProductVariation;

class VendirunTestCase extends \TestCase {

    /**
     * @param int $price
     * @param int $quantity
     * @param bool $priceIncludesTax
     * @param int $shippingPrice
     * @param string $shippingType
     * @param null $supplierId
     * @return CartItem
     */
    protected function makeCartItem($price = 100, $quantity = 3, $priceIncludesTax = true, $shippingPrice = 50, $shippingType = 'Standard Shipping', $supplierId = null)
    {
        $variationId = rand(1000,2000000);

        $variationParams = [
            'id' => $variationId,
            'name' => '',
            'price' => $price,
            'sku' => '123x'
        ];

        $productParams = [
            'id' => rand(1,1000000),
            'productName' => 'My Test Product',
            'productType' => '',
            'shortDescription' => '',
            'longDescription' => '',
            'keywords' =>  '',
            'images' => '',
            'video' => '',
            'shipping' => [
                new ProductShippingOption($shippingPrice, $shippingPrice, $shippingType, $supplierId, [79]),
                new ProductShippingOption($shippingPrice + 50, $shippingPrice, 'Special Delivery', $supplierId, [79])
            ],
            'tax' => [
                new ProductTaxOption(20, [79], true)
            ],
            'variations' => [
                new ProductVariation($variationParams)
            ],
            'relatedProducts' => null
        ];

        $product = new Product($productParams);

        $cartItem = new CartItem([
            'productVariationId' => $variationId,
            'quantity' => $quantity,
            'product' => $product,
            'basePrice' => $price,
            'taxRate' => 20,
            'shippingType' => $shippingType,
            'countryId' => 79,
            'priceIncludesTax' => $priceIncludesTax
        ]);

        return $cartItem;
    }

    /**
     * @param bool $priceIncludesTax
     * @param bool $shippingIsNull
     * @param string $shippingType
     * @param bool $includeSuppliers
     * @param bool $freeShipping
     * @return Cart
     */
    protected function makeCart($priceIncludesTax = true, $shippingIsNull = false, $shippingType = 'Standard Shipping', $includeSuppliers = false, $freeShipping = false)
    {
        $params = [
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => true,
            'defaultTaxRate' => 20,
            'freeShipping' => $freeShipping
        ];

        $cart = new Cart($params);

        foreach ($this->makeMultipleItems(3, $priceIncludesTax, 100, $shippingIsNull ? null : 50, $shippingType, $includeSuppliers) as $cartItem)
        {
            $cart->add($cartItem);
        }

        return $cart;
    }

    /**
     * @param bool $priceIncludesTax
     * @param int $cartItemQuantity
     * @return Cart
     */
    protected function makeCart2($priceIncludesTax = true, $cartItemQuantity = 1)
    {
        $params = [
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => true,
            'defaultTaxRate' => 20
        ];

        $cart = new Cart($params);

        $variationParams = [
            'id' => 55,
            'name' => 'Test Three',
            'price' => 2500,
            'sku' => '123x'
        ];

        $product = new Product([
            'id' => 1,
            'productName' => '',
            'productType' => '',
            'shortDescription' => '',
            'longDescription' => '',
            'shipping' => [
                new ProductShippingOption(300, 15, 'Standard Shipping', 2, [79])
            ],
            'tax' => [
                new ProductTaxOption(20, [79], true)
            ],
            'variations' => [
                new ProductVariation($variationParams)
            ]
        ]);

        $cartItem = new CartItem([
            'productVariationId' => 55,
            'quantity' => $cartItemQuantity,
            'product' => $product,
            'basePrice' => 2500,
            'taxRate' => 20,
            'shippingType' => 'Standard Shipping',
            'countryId' => 79,
            'priceIncludesTax' => $priceIncludesTax
        ]);

        $cart->add($cartItem);

        $variationParams['name'] = 'Test Two';
        $variationParams['id'] = 56;
        $variationParams['price'] = 1500;

        $product = new Product([
            'id' => 2,
            'productName' => '',
            'productType' => '',
            'shortDescription' => '',
            'longDescription' => '',
            'shipping' => [
                new ProductShippingOption(200, 25, 'Standard Shipping', 1, [79])
            ],
            'tax' => [
                new ProductTaxOption(20, [79], true)
            ],
            'variations' => [
                new ProductVariation($variationParams)
            ]
        ]);

        $cartItem = new CartItem([
            'productVariationId' => 56,
            'quantity' => $cartItemQuantity,
            'product' => $product,
            'basePrice' => 1500,
            'taxRate' => 20,
            'shippingType' => 'Standard Shipping',
            'countryId' => 79,
            'priceIncludesTax' => $priceIncludesTax
        ]);

        $cart->add($cartItem);

        $variationParams['name'] = 'Test One';
        $variationParams['id'] = 57;
        $variationParams['price'] = 1200;

        $product = new Product([
            'id' => 3,
            'productName' => '',
            'productType' => '',
            'shortDescription' => '',
            'longDescription' => '',
            'shipping' => [
                new ProductShippingOption(100, 50, 'Standard Shipping', null, [79])
            ],
            'tax' => [
                new ProductTaxOption(20, [79], true)
            ],
            'variations' => [
                new ProductVariation($variationParams)
            ]
        ]);

        $cartItem = new CartItem([
            'productVariationId' => 57,
            'quantity' => $cartItemQuantity,
            'product' => $product,
            'basePrice' => 1200,
            'taxRate' => 20,
            'shippingType' => 'Standard Shipping',
            'countryId' => 79,
            'priceIncludesTax' => $priceIncludesTax
        ]);

        $cart->add($cartItem);

        return $cart;
    }

    /**
     * @param $number
     * @param bool $priceIncludesTax
     * @param int $price
     * @param int $shippingPrice
     * @param string $shippingType
     * @param bool $includeSuppliers
     * @return array
     */
    protected function makeMultipleItems($number, $priceIncludesTax = true, $price = 100, $shippingPrice = 50, $shippingType = 'Standard Shipping', $includeSuppliers = false)
    {
        $items = [];

        // if we are including suppliers, make the first one null, the second one 1 and the rest all 2 (three suppliers total)
        $supplierId = null;
        $startAt = 1;
        if ($includeSuppliers)
        {
            $items[] = $this->makeCartItem($price, 1, $priceIncludesTax, $shippingPrice, $shippingType, null);

            if ($number == 1) return $items;

            $items[] = $this->makeCartItem($price, 1, $priceIncludesTax, $shippingPrice, $shippingType, 1);

            if ($number == 2) return $items;

            $supplierId = 2;
            $startAt = 3;
        }

        for ($i = $startAt; $i <= $number; $i++) $items[] = $this->makeCartItem($price, 1, $priceIncludesTax, $shippingPrice, $shippingType, $supplierId);
        return $items;
    }

}