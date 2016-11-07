<?php namespace AlistairShaw\Vendirun\Tests\App\Entities\Cart\CartItem\Transformers;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\Transformers\CartItemValuesVATExcludedTransformer;
use AlistairShaw\Vendirun\Tests\App\VendirunTestCase;

class CartItemValuesVATExcludedTransformerTest extends VendirunTestCase  {

    public function testGetValues()
    {
        $cartItem = $this->makeCartItem(100, 1, false);

        $transformer = new CartItemValuesVATExcludedTransformer();
        $values = $cartItem->getValues($transformer);

        $this->assertArrayHasKey('total', $values);
        $this->assertArrayHasKey('shipping', $values);
        $this->assertArrayHasKey('tax', $values);

        $this->assertEquals(100, $values['total']);
        $this->assertEquals(20, $values['tax']);
        $this->assertEquals(50, $values['shipping']);
    }

    public function testCartItemNullShippingValues()
    {
        $cartItem = $this->makeCartItem(100, 1, false, null);

        $transformer = new CartItemValuesVATExcludedTransformer();

        $values = $cartItem->getValues($transformer);

        $this->assertArrayHasKey('total', $values);
        $this->assertArrayHasKey('shipping', $values);
        $this->assertArrayHasKey('tax', $values);

        $this->assertEquals(100, $values['total']);
        $this->assertEquals(20, $values['tax']);
        $this->assertNull($values['shipping']);
    }

    public function testCartItemShippingBeforeTax()
    {
        $cartItem = $this->makeCartItem(100, 3, false);

        $transformer = new CartItemValuesVATExcludedTransformer();
        $values = $cartItem->getValues($transformer);

        $this->assertArrayHasKey('total', $values);
        $this->assertArrayHasKey('shipping', $values);
        $this->assertArrayHasKey('tax', $values);
        $this->assertArrayHasKey('shipping_before_tax', $values);

        $this->assertEquals(300, $values['total']);
        $this->assertEquals(60, $values['tax']);
        $this->assertEquals(150, $values['shipping']);
        $this->assertEquals(150, $values['shipping_before_tax']);
    }

}