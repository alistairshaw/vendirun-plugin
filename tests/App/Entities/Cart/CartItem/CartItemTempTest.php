<?php namespace AlistairShaw\Vendirun\Tests\App\Entities\Cart\CartItem;

use AlistairShaw\Vendirun\Tests\App\VendirunTestCase;

class CartItemTempTest extends VendirunTestCase {

    public function testShippingTax()
    {
        //$cartItem = $this->makeCartItem();
        //$this->assertEquals(25, $cartItem->shippingTax());

        $cartItem = $this->makeCartItem(10100, 3, false);
        $this->assertEquals(30, $cartItem->shippingTax());
    }
}