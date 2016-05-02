<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Customer\Customer;
use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\Entities\Order\Payment\Payment;
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
     * @var array
     */
    private $payments;

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
     * @var string
     */
    private $createdAt;

    /**
     * Order constructor.
     * @param Customer $customer
     * @param Address $billingAddress
     * @param Address $shippingAddress
     * @param          $items
     * @param string $shippingType
     * @param null $id
     * @param null $createdAt
     */
    public function __construct(Customer $customer, Address $billingAddress, Address $shippingAddress, $items, $shippingType = '', $id = null, $createdAt = null)
    {
        $this->customer = $customer;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
        $this->items = $items;
        $this->shippingType = $shippingType;
        $this->id = $id;
        $this->createdAt = $createdAt ? $createdAt : date("Y-m-d H:i:s");
        $this->payments = [];
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
     * Unique items WITHOUT shipping
     * @param bool $ignorePriceDifferences
     * @return object
     */
    public function getUniqueItems($ignorePriceDifferences = false)
    {
        $final = [];
        foreach ($this->getItems() as $item)
        {
            /* @var $item OrderItem */

            if ($item->isShipping()) continue;

            // find match in final
            $matched = false;
            foreach ($final as $index => $finalItem)
            {
                if ($item->getProductName() == $finalItem->productName
                    && $item->getProductSku() == $finalItem->sku
                    && $item->getProductVariationId() == $finalItem->productVariationId
                    && $item->getTaxRate() == $finalItem->taxRate
                    && ($item->getPrice() == $finalItem->unitPrice || $ignorePriceDifferences)
                    )
                {
                    $matched = true;
                    $final[$index]->price += $item->getPrice();
                    $final[$index]->quantity++;
                }
            }

            // if no match in final, add new row to final
            if (!$matched)
            {
                $final[] = (object)[
                    'price' => (int)$item->getPrice(),
                    'unitPrice' => (int)$item->getPrice(),
                    'productName' => $item->getProductName(),
                    'sku' => $item->getProductSku(),
                    'productVariationId' => $item->getProductVariationId(),
                    'taxRate' => $item->getTaxRate(),
                    'quantity' => 1,
                    'priceWithTax' => TaxCalculator::totalPlusTax($item->getPrice(), $item->getTaxRate())
                ];
            }
        }

        return (object)$final;
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
        foreach ($this->getUniqueItems() as $item)
        {
            $tax += TaxCalculator::totalPlusTax($item->price, $item->taxRate);
        }

        return $tax + $this->getShippingTax();
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
        foreach ($this->concatItems() as $item)
        {
            $total += $item['price'] + TaxCalculator::totalPlusTax($item['price'], $item['taxRate']);
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
        foreach ($this->concatItems() as $item)
        {
            $total += $item['price'];
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
        $status = 'Pending Payment';
        if ($this->getTotalPrice() <= $this->getTotalPaid()) $status = 'Order Processing';

        return $status;
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
     * @return array
     */
    public function concatItems()
    {
        $final = [];
        foreach ($this->getItems() as $item)
        {
            /* @var $item OrderItem */
            if (isset($final[$item->getProductVariationId()]))
            {
                $final[$item->getProductVariationId()]['price'] += $item->getPrice();
                $final[$item->getProductVariationId()]['quantity']++;
            }
            else
            {
                $final[$item->getProductVariationId()] = [
                    'productSku' => $item->getProductSku(),
                    'productName' => $item->getProductName(),
                    'price' => $item->getPrice(),
                    'quantity' => 1,
                    'discount' => 0,
                    'taxRate' => $item->getTaxRate()
                ];
            }
        }

        return $final;
    }

    /**
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->createdAt;
    }

}