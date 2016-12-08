<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\NameExploder\Exceptions\OrderItemNotFoundException;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Customer\Customer;
use AlistairShaw\Vendirun\App\Entities\Order\Aggregates\OrderStatus;
use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\Entities\Order\Payment\Payment;
use AlistairShaw\Vendirun\App\Entities\Order\Shipment\Shipment;
use AlistairShaw\Vendirun\App\ValueObjects\Address;
use Mockery\CountValidator\Exception;

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
     * @var array
     */
    private $payments;

    /**
     * @var array
     */
    private $shipments;

    /**
     * @var string
     */
    private $shippingType;

    /**
     * This allows us to recall one order one time, for the order confirmation screen,
     *    if the customer is checking out as a guest
     * @var string
     */
    private $oneTimeToken;

    /**
     * @var OrderStatus
     */
    private $orderStatus;

    /**
     * Order constructor.
     * @param Customer $customer
     * @param Address $billingAddress
     * @param Address $shippingAddress
     * @param          $items
     * @param string $shippingType
     * @param null $id
     * @param OrderStatus $orderStatus
     * @internal param null $createdAt
     */
    public function __construct(Customer $customer, Address $billingAddress = null, Address $shippingAddress = null, $items = [], $shippingType = '', $id = null, OrderStatus $orderStatus = null)
    {
        $this->customer = $customer;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
        $this->items = $items;
        $this->shippingType = $shippingType;
        $this->id = $id;

        $this->payments = [];
        $this->shipments = [];
        $this->orderStatus = $orderStatus ? $orderStatus : new OrderStatus(date("Y-m-d H:i:s"));
    }

    /**
     * @param Payment $payment
     */
    public function addPayment(Payment $payment)
    {
        $this->payments[] = $payment;
    }

    /**
     * @return array
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param Shipment $shipment
     */
    public function addShipment(Shipment $shipment)
    {
        $this->shipments[] = $shipment;
    }

    /**
     * @return array
     */
    public function getShipments()
    {
        return $this->shipments;
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
     * Totals for shipping
     * @return int
     */
    public function getShipping()
    {
        $shipping = 0;
        foreach ($this->getItems() as $item)
        {
            /* @var $item OrderItem */
            if ($item->isShipping()) $shipping += $item->getPrice();
        }

        return $shipping;
    }

    /**
     * @return int
     */
    public function getShippingTax()
    {
        $shipping = 0;
        $taxRate = 0;
        foreach ($this->getItems() as $item)
        {
            /* @var $item OrderItem */
            if ($item->isShipping())
            {
                $taxRate = $item->getTaxRate();
                $shipping += $item->getPrice();
            }
        }

        return TaxCalculator::totalPlusTax($shipping, $taxRate);
    }

    /**
     * @return int
     */
    public function getTax()
    {
        $tax = 0;
        foreach ($this->getItems() as $item)
        {
            /* @var $item OrderItem */
            $tax += TaxCalculator::totalPlusTax($item->getPrice(), $item->getTaxRate());
        }

        return $tax;
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
        foreach ($this->getItems() as $item)
        {
            $total += $item->getPrice() + TaxCalculator::totalPlusTax($item->getPrice(), $item->getTaxRate());
        }

        return $total;
    }

    /**
     * @return int
     */
    public function getPriceBeforeTax()
    {
        if (!$this->items) return 0;
        $total = 0;
        foreach ($this->items as $item)
        {
            $total += $item->getPrice();
        }

        return $total;
    }

    /**
     * @return string
     */
    public function getOneTimeToken()
    {
        return $this->oneTimeToken;
    }

    /**
     * @param string $oneTimeToken
     */
    public function setOneTimeToken($oneTimeToken)
    {
        $this->oneTimeToken = $oneTimeToken;
    }

    /**
     * Returns the current overall status of the order
     * @return string
     */
    public function getStatus()
    {
        return $this->orderStatus->getStatus();
    }

    /**
     * @return int
     */
    public function getTotalPaid()
    {
        $totalPaid = 0;
        foreach ($this->payments as $payment)
        {
            /* @var $payment Payment */
            $totalPaid += $payment->getAmount();
        }
        return $totalPaid;
    }

    /**
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->orderStatus->getCreated();
    }

    /**
     * @param $orderItemId
     * @return OrderItem
     * @throws OrderItemNotFoundException
     */
    public function getItemById($orderItemId)
    {
        foreach ($this->items as $item)
        {
            if ($item->getId() == $orderItemId) return $item;
        }

        throw new OrderItemNotFoundException('No item found for ID ' . $orderItemId);
    }

}