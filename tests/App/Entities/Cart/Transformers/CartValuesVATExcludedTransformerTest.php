<?php namespace AlistairShaw\Vendirun\Tests\App\Entities\Cart\Transformers;

use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesVATExcludedTransformer;
use AlistairShaw\Vendirun\Tests\App\VendirunTestCase;

class CartValuesVATExcludedTransformerTest extends VendirunTestCase {

    public function testGetValues()
    {
        $cart = $this->makeCart(false);
        $transformer = new CartValuesVATExcludedTransformer();
        $values = $cart->getValues($transformer);

        $this->assertArrayHasKey('subTotal', $values);
        $this->assertArrayHasKey('displayTotal', $values);
        $this->assertArrayHasKey('shipping', $values);
        $this->assertArrayHasKey('displayShipping', $values);
        $this->assertArrayHasKey('tax', $values);
        $this->assertArrayHasKey('total', $values);

        $this->assertEquals(360, $values['subTotal']);
        $this->assertEquals(300, $values['displayTotal']);
        $this->assertEquals(240, $values['shipping']);
        $this->assertEquals(200, $values['displayShipping']);
        $this->assertEquals(100, $values['tax']);
        $this->assertEquals(600, $values['total']);
    }

}