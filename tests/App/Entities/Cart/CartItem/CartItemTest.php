<?php namespace AlistairShaw\Vendirun\Test;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;

class CartItemTest extends \PHPUnit_Framework_TestCase {

    public function testGetSingleItemPrice()
    {
        $cartItem = $this->makeCartItem(100, 3, true);
        $this->assertEquals(83, $cartItem->getSingleItemPrice(1));
        $this->assertEquals(83, $cartItem->getSingleItemPrice(2));
        $this->assertEquals(84, $cartItem->getSingleItemPrice(3));

        $cartItem = $this->makeCartItem(100, 3, false);
        $this->assertEquals(100, $cartItem->getSingleItemPrice(1));
        $this->assertEquals(100, $cartItem->getSingleItemPrice(2));
        $this->assertEquals(100, $cartItem->getSingleItemPrice(3));
    }

    public function testShippingTax()
    {
        $cartItem = $this->makeCartItem();
        $this->assertEquals(25, $cartItem->shippingTax());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(30, $cartItem->shippingTax());
    }

    public function testTax()
    {
        $cartItem = $this->makeCartItem(100);
        $this->assertEquals(75, $cartItem->tax());

        $cartItem = $this->makeCartItem(10100);
        $this->assertEquals(5075, $cartItem->tax());

        $cartItem = $this->makeCartItem(100, 3, false);
        $this->assertEquals(90, $cartItem->tax());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(6090, $cartItem->tax());
    }

    public function testDisplayShipping()
    {
        $cartItem = $this->makeCartItem(100, 5);
        $this->assertEquals(250, $cartItem->displayShipping());

        $cartItem = $this->makeCartItem(100, 5, false);
        $this->assertEquals(250, $cartItem->displayShipping());
    }

    public function testShippingBeforeTax()
    {
        $cartItem = $this->makeCartItem();
        $this->assertEquals(125, $cartItem->shippingBeforeTax());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(150, $cartItem->shippingBeforeTax());
    }

    public function testShipping()
    {
        $cartItem = $this->makeCartItem();
        $this->assertEquals(150, $cartItem->shipping());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(180, $cartItem->shipping());
    }

    public function testDisplayTotal()
    {
        $cartItem = $this->makeCartItem();
        $this->assertEquals(300, $cartItem->displayTotal());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(30300, $cartItem->displayTotal());
    }

    public function testTotalWithoutShipping()
    {
        $cartItem = $this->makeCartItem();
        $this->assertEquals(300, $cartItem->totalWithoutShipping());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(36360, $cartItem->totalWithoutShipping());
    }

    public function testTotalBeforeTax()
    {
        $cartItem = $this->makeCartItem(10100);
        $this->assertEquals(25250, $cartItem->totalBeforeTax());

        $cartItem = $this->makeCartItem(100);
        $this->assertEquals(250, $cartItem->totalBeforeTax());

        $cartItem = $this->makeCartItem(100, 3, false);
        $this->assertEquals(300, $cartItem->totalBeforeTax());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(30300, $cartItem->totalBeforeTax());
    }

    public function testTaxWithoutShipping()
    {
        $cartItem = $this->makeCartItem(100);
        $this->assertEquals(50, $cartItem->taxWithoutShipping());

        $cartItem = $this->makeCartItem(10100);
        $this->assertEquals(5050, $cartItem->taxWithoutShipping());

        $cartItem = $this->makeCartItem(100, 3, false);
        $this->assertEquals(60, $cartItem->taxWithoutShipping());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(6060, $cartItem->taxWithoutShipping());
    }

    public function testTotal()
    {
        $cartItem = $this->makeCartItem(10100);
        $this->assertEquals(30450, $cartItem->total());

        $cartItem = $this->makeCartItem(100);
        $this->assertEquals(450, $cartItem->total());

        $cartItem = $this->makeCartItem(100, 3, false);
        $this->assertEquals(540, $cartItem->total());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(36540, $cartItem->total());
    }

    private function makeCartItem($price = 100, $quantity = 3, $priceIncludesTax = true)
    {
        return new CartItem([
            'productVariationId' => 55,
            'quantity' => $quantity,
            'taxRate' => 20.0,
            'productVariation' => [],
            'product' => [],
            'basePrice' => $price,
            'shippingPrice' => 50,
            'shippingTaxRate' => 20.0,
            'priceIncludesTax' => $priceIncludesTax
        ]);
    }
}