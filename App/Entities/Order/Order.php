<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Entities\Customer\Customer;
use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\ValueObjects\Address;

class Order {

    /**
     * @var string
     */
    private $id;

    /**
     * @var Customer
     */
    private $customer;

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
     * @var string
     */
    private $shippingType;

    /**
     * Order constructor.
     * @param Customer $customer
     * @param Address  $billingAddress
     * @param Address  $shippingAddress
     * @param          $items
     * @param string   $shippingType
     * @param null     $id
     */
    public function __construct(Customer $customer, Address $billingAddress, Address $shippingAddress, $items, $shippingType = '', $id = null)
    {
        $this->customer = $customer;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
        $this->items = $items;
        $this->shippingType = $shippingType;
        $this->id = $id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @return Address
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getShippingType()
    {
        return $this->shippingType;
    }

    /**
     * @return int
     */
    public function getTotalPrice()
    {
        if (!$this->items) return 0;
        $total = 0;
        foreach ($this->items as $item)
        {
            /* @var $item OrderItem */
            $total += $item->getItemTotal();
        }

        return $total;
    }

}