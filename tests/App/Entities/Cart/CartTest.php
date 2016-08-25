<?php namespace AlistairShaw\Vendirun\Tests\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\Tests\App\CampusTestCase;

class CartTest extends CampusTestCase {

    public function testGetDefaultTaxRate()
    {
        $cart = $this->makeCart(false);
        $this->assertEquals(20, $cart->getDefaultTaxRate());
    }

    public function testOrderShippingBeforeTax()
    {
        $cart = $this->makeCart(false);
        $this->assertEquals(50, $cart->orderShippingBeforeTax());

        $cart = $this->makeCart(true);
        $this->assertEquals(42, $cart->orderShippingBeforeTax());
    }

    public function testOrderShippingTax()
    {
        $cart = $this->makeCart(false);
        $this->assertEquals(10, $cart->orderShippingTax());

        $cart = $this->makeCart(true);
        $this->assertEquals(8, $cart->orderShippingTax());
    }

    /**
     * Total includes price, tax and shipping
     */
    public function testTotal()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(500, $cart->total());

        $cart = $this->makeCart(false);
        $this->assertEquals(600, $cart->total());
    }

    public function testShippingTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(33, $cart->shippingTax());

        $cart = $this->makeCart(false);
        $this->assertEquals(40, $cart->shippingTax());
    }

    public function testTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(83, $cart->tax());

        $cart = $this->makeCart(false);
        $this->assertEquals(100, $cart->tax());
    }

    public function testTaxWithoutShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(50, $cart->taxWithoutShipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(60, $cart->taxWithoutShipping());
    }

    public function testDisplayShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(200, $cart->displayShipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(200, $cart->displayShipping());
    }

    public function testDisplayOrderShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(50, $cart->displayOrderShipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(50, $cart->displayOrderShipping());
    }

    public function testShippingBeforeTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(168, $cart->shippingBeforeTax());

        $cart = $this->makeCart(false);
        $this->assertEquals(200, $cart->shippingBeforeTax());
    }

    public function testShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(200, $cart->shipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(240, $cart->shipping());
    }

    public function testDisplayTotal()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(300, $cart->displayTotal());

        $cart = $this->makeCart(false);
        $this->assertEquals(300, $cart->displayTotal());
    }

    public function testTotalBeforeTax()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(250, $cart->totalBeforeTax());

        $cart = $this->makeCart(false);
        $this->assertEquals(300, $cart->totalBeforeTax());
    }

    public function testTotalWithoutShipping()
    {
        $cart = $this->makeCart(true);
        $this->assertEquals(300, $cart->totalWithoutShipping());

        $cart = $this->makeCart(false);
        $this->assertEquals(360, $cart->totalWithoutShipping());
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
     * When shipping is not available, shipping price returns null
     *    and so should all the other shipping related functions, to
     *    indicate shipping not available
     */
    /*public function testNullShipping()
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
    }*/

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
            'priceIncludesTax' => $priceIncludesTax,
            'chargeTaxOnShipping' => true,
            'defaultTaxRate' => 20,
            'orderShippingPrice' => 100
        ];

        $cart = new Cart($params);
        return $cart;
    }

    /**
     * @param $number
     * @param bool $priceIncludesTax
     * @param int $price
     * @param int $shippingPrice
     * @param string $shippingType
     * @return array
     */
    private function makeMultipleItems($number, $priceIncludesTax = true, $price = 100, $shippingPrice = 50, $shippingType = 'Standard Shipping')
    {
        $items = [];
        for ($i = 1; $i <= $number; $i++) $items[] = $this->makeCartItem($price, 1, $priceIncludesTax, $shippingPrice, 20, $shippingType);
        return $items;
    }

}