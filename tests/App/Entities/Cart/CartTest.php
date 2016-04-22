<?php namespace AlistairShaw\Vendirun\Test;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;

class CartTest extends \PHPUnit_Framework_TestCase {

    public function testOrderShippingTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(25, $cart->orderShippingTax());

        $cart = $this->makeCart(false);
        $this->assertEquals(30, $cart->orderShippingTax());
    }

    public function testShippingTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(100, $cart->shippingTax());

        $cart = $this->makeCart(false);
        $this->assertEquals(120, $cart->shippingTax());
    }

    public function testTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(250, $cart->tax());

        $cart = $this->makeCart(false);
        $this->assertEquals(300, $cart->tax());
    }

    public function testTaxWithoutShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(150, $cart->taxWithoutShipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(180, $cart->taxWithoutShipping());
    }

    public function testDisplayShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(600, $cart->displayShipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(600, $cart->displayShipping());
    }

    public function testOrderShippingBeforeTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(125, $cart->orderShippingBeforeTax());

        $cart = $this->makeCart(false);
        $this->assertEquals(150, $cart->orderShippingBeforeTax());
    }

    public function testDisplayOrderShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(150, $cart->displayOrderShipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(150, $cart->displayOrderShipping());
    }

    public function testShippingBeforeTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(500, $cart->shippingBeforeTax());

        $cart = $this->makeCart(false);
        $this->assertEquals(600, $cart->shippingBeforeTax());
    }

    public function testShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(600, $cart->shipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(720, $cart->shipping());
    }

    public function testDisplayTotal()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(900, $cart->displayTotal());

        $cart = $this->makeCart(false);
        $this->assertEquals(900, $cart->displayTotal());
    }

    public function testTotalBeforeTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(750, $cart->totalBeforeTax());

        $cart = $this->makeCart(false);
        $this->assertEquals(900, $cart->totalBeforeTax());
    }

    public function testTotalWithoutShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(900, $cart->totalWithoutShipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(1080, $cart->totalWithoutShipping());
    }

    public function testTotal()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(1500, $cart->total());

        $cart = $this->makeCart(false);
        $this->assertEquals(1800, $cart->total());
    }

    /**
     * When shipping is not available, shipping price returns null
     *    and so should all the other shipping related functions, to
     *    indicate shipping not available
     */
    public function testNullShipping()
    {
        $cart = $this->makeCart(true, true);
        $this->assertNull($cart->shipping());
        $this->assertNull($cart->shippingBeforeTax());
        $this->assertNull($cart->shippingTax());
        $this->assertNull($cart->displayShipping());
        $this->assertNull($cart->displayOrderShipping());
        $this->assertNull($cart->orderShippingTax());
        $this->assertNull($cart->orderShippingBeforeTax());
    }

    public function testReturnsCorrectShippingType()
    {
        $cart = $this->makeCart(true, false, 'Express Shipping');
        $this->assertEquals('Express Shipping', $cart->getShippingType());
    }

    /**
     * @param bool   $priceIncludesTax
     * @param bool   $shippingIsNull
     * @param string $shippingType
     * @return Cart
     */
    private function makeCart($priceIncludesTax = true, $shippingIsNull = false, $shippingType = 'Standard Shipping')
    {
        $params = [
            'ids' => [1,2,3],
            'items' => $this->makeMultipleItems(3, $priceIncludesTax, 100, $shippingIsNull ? null : 50, $shippingType),
            'countryId' => 72,
            'shippingType' => $shippingType,
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => true,
            'defaultTaxRate' => 20.0,
            'orderShippingPrice' => $shippingIsNull ? null : 150,
            'availableShippingTypes' => [
                'Standard Shipping',
                'Express Shipping'
            ],
        ];
        return new Cart($params);
    }

    /**
     * @param      $number
     * @param bool $priceIncludesTax
     * @param int  $price
     * @param int  $shippingPrice
     * @return array
     */
    private function makeMultipleItems($number, $priceIncludesTax = true, $price = 100, $shippingPrice = 50)
    {
        $items = [];
        for ($i = 1; $i <= $number; $i++) $items[] = $this->makeCartItem($price, 3, $priceIncludesTax, $shippingPrice);
        return $items;
    }

    /**
     * @param int  $price
     * @param int  $quantity
     * @param bool $priceIncludesTax
     * @param int  $shippingPrice
     * @return CartItem
     */
    private function makeCartItem($price = 100, $quantity = 3, $priceIncludesTax = true, $shippingPrice = 50)
    {
        return new CartItem([
            'productVariationId' => 55,
            'quantity' => $quantity,
            'taxRate' => 20.0,
            'productVariation' => [],
            'product' => [],
            'basePrice' => $price,
            'shippingPrice' => $shippingPrice,
            'shippingTaxRate' => $shippingPrice === null ? null : 20.0,
            'priceIncludesTax' => $priceIncludesTax
        ]);
    }

}