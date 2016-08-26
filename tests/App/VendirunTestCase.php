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
     * @param int $shippingTaxRate
     * @param string $shippingType
     * @param null $supplierId
     * @return CartItem
     */
    protected function makeCartItem($price = 100, $quantity = 3, $priceIncludesTax = true, $shippingPrice = 50, $shippingTaxRate = 20, $shippingType = 'Standard Shipping', $supplierId = null)
    {
        $variationParams = [
            'id' => rand(1000000, 2000000),
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
            'productVariationId' => 55,
            'quantity' => $quantity,
            'product' => $product,
            'basePrice' => $price,
            'taxRate' => 20,
            'shippingType' => $shippingType,
            'countryId' => 79,
            'priceIncludesTax' => $priceIncludesTax,
            'shippingTaxRate' => $shippingTaxRate
        ]);

        return $cartItem;
    }

    /**
     * @param bool $priceIncludesTax
     * @param bool $shippingIsNull
     * @param string $shippingType
     * @param bool $includeSuppliers
     * @return Cart
     */
    protected function makeCart($priceIncludesTax = true, $shippingIsNull = false, $shippingType = 'Standard Shipping', $includeSuppliers = false)
    {
        $params = [
            'ids' => [1,2,3],
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => true,
            'defaultTaxRate' => 20,
        ];

        $cart = new Cart($params);

        foreach ($this->makeMultipleItems(3, $priceIncludesTax, 100, $shippingIsNull ? null : 50, $shippingType, $includeSuppliers) as $cartItem)
        {
            $cart->add($cartItem);
        }

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
            $items[] = $this->makeCartItem($price, 1, $priceIncludesTax, $shippingPrice, 20, $shippingType, null);
            $items[] = $this->makeCartItem($price, 1, $priceIncludesTax, $shippingPrice, 20, $shippingType, 1);
            $supplierId = 2;
            $startAt = 3;
        }

        for ($i = $startAt; $i <= $number; $i++) $items[] = $this->makeCartItem($price, 1, $priceIncludesTax, $shippingPrice, 20, $shippingType, $supplierId);
        return $items;
    }

}