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

        $this->assertEquals(300, $values['subTotal']);
        $this->assertEquals(300, $values['displayTotal']);
        $this->assertEquals(200, $values['shipping']);
        $this->assertEquals(200, $values['displayShipping']);
        $this->assertEquals(84, $values['tax']);
        $this->assertEquals(500, $values['total']);
    }

    public function testCartNullShippingValues()
    {
        $cart = $this->makeCart(false, true);
        $transformer = new CartValuesVATIncludedTransformer();
        $values = $cart->getValues($transformer);

        $this->assertArrayHasKey('subTotal', $values);
        $this->assertArrayHasKey('displayTotal', $values);
        $this->assertArrayHasKey('shipping', $values);
        $this->assertArrayHasKey('displayShipping', $values);
        $this->assertArrayHasKey('tax', $values);
        $this->assertArrayHasKey('total', $values);

        $this->assertEquals(300, $values['subTotal']);
        $this->assertEquals(300, $values['displayTotal']);
        $this->assertNull($values['shipping']);
        $this->assertNull($values['displayShipping']);
        $this->assertEquals(51, $values['tax']);
        $this->assertEquals(300, $values['total']);
    }

}