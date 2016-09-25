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

}