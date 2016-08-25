<?php namespace AlistairShaw\Vendirun\Tests\App;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption\ProductShippingOption;
use AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption\ProductTaxOption;
use AlistairShaw\Vendirun\App\Entities\Product\ProductVariation\ProductVariation;

class CampusTestCase extends \TestCase {

    /**
     * @param int $price
     * @param int $quantity
     * @param bool $priceIncludesTax
     * @param int $shippingPrice
     * @param int $shippingTaxRate
     * @param string $shippingType
     * @return CartItem
     */
    protected function makeCartItem($price = 100, $quantity = 3, $priceIncludesTax = true, $shippingPrice = 50, $shippingTaxRate = 20, $shippingType = 'Standard Shipping')
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
                new ProductShippingOption($shippingPrice, $shippingType, [79])
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

        return new CartItem([
            'productVariationId' => 55,
            'quantity' => $quantity,
            'taxRate' => 20,
            'productVariation' => [],
            'product' => $product,
            'basePrice' => $price,
            'shippingPrice' => $shippingPrice,
            'shippingTaxRate' => $shippingTaxRate,
            'priceIncludesTax' => $priceIncludesTax
        ]);
    }

}