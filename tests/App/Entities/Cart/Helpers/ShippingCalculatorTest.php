<?php namespace AlistairShaw\Vendirun\Tests\App\Entities\Cart\Helpers;

use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\ShippingCalculator;
use AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption\ProductShippingOption;
use AlistairShaw\Vendirun\Tests\App\VendirunTestCase;

class ShippingCalculatorTest extends VendirunTestCase {

    public function testShippingForItem()
    {
        $result = ShippingCalculator::shippingForItem($this->makeShipping(), 1, 79, 'Standard Shipping');
        $this->assertEquals(50, $result);
    }

    public function testAvailableShippingTypes()
    {
        $result = ShippingCalculator::availableShippingTypes($this->makeCart());
        $this->assertEquals(2, count($result));
    }

    public function testOrderShippingCharge()
    {
        $result = ShippingCalculator::orderShippingCharge($this->makeCart());
        $this->assertEquals(50, $result);
    }

    public function testSpecialDelivery()
    {
        $result = ShippingCalculator::orderShippingCharge($this->makeCart(true, false, 'Special Delivery'));
        $this->assertEquals(100, $result);
    }

    public function testWithSuppliers()
    {
        $result = ShippingCalculator::orderShippingCharge($this->makeCart(true, false, 'Standard Shipping', true));
        $this->assertEquals(150, $result);
    }

    public function testWithSuppliersAgain()
    {
        $result = ShippingCalculator::orderShippingCharge($this->makeCart2(true));
        $this->assertEquals(600, $result);
    }

    private function makeShipping()
    {
        return [
            new ProductShippingOption(100, 50, 'Standard Shipping', null, [79,72]),
            new ProductShippingOption(200, 75, 'Express Shipping', null, [79,72]),
        ];
    }
}