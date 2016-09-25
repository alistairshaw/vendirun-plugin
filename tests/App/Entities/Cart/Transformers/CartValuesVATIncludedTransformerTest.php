<?php namespace AlistairShaw\Vendirun\Tests\App\Entities\Cart\Transformers;

use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesVATIncludedTransformer;
use AlistairShaw\Vendirun\Tests\App\VendirunTestCase;

class CartValuesVATIncludedTransformerTest extends VendirunTestCase {

    public function testGetValues()
    {
        $cart = $this->makeCart(false);
        $transformer = new CartValuesVATIncludedTransformer();
        $values = $cart->getValues($transformer);

        $this->assertArrayHasKey('subTotal', $values);
        $this->assertArrayHasKey('displayTotal', $values);
        $this->assertArrayHasKey('shipping', $values);
        $this->assertArrayHasKey('displayShipping', $values);
        $this->assertArrayHasKey('tax', $values);
        $this->assertArrayHasKey('total', $values);

        $this->assertEquals(351, $values['subTotal']);
        $this->assertEquals(300, $values['displayTotal']);
        $this->assertEquals(233, $values['shipping']);
        $this->assertEquals(200, $values['displayShipping']);
        $this->assertEquals(51, $values['tax']);
        $this->assertEquals(584, $values['total']);
    }

}