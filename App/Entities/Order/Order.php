<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\ValueObjects\Address;

class Order {

    /**
     * @var Address
     */
    private $billingAddress;

    /**
     * @var Address
     */
    private $shippingAddress;

    /**
     * @var array
     */
    private $items;

    /**
     * Order constructor.
     * @param Address $billingAddress
     * @param Address $shippingAddress
     * @param         $items
     */
    public function __construct(Address $billingAddress, Address $shippingAddress, $items)
    {
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
        $this->items = $items;
    }

}