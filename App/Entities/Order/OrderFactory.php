<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Customer\Customer;
use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\ValueObjects\Address;
use AlistairShaw\Vendirun\App\ValueObjects\Name;

class OrderFactory {

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * OrderFactory constructor.
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param Cart     $cart
     * @param Customer $customer
     * @param array    $params
     * @return Order
     */
    public function fromCart(Cart $cart, Customer $customer, $params)
    {
        if (isset($params['shippingAddressId']))
        {
            $shippingAddress = new Address(['id' => $params['shippingAddressId']]);
        }
        else
        {
            $data = [
                'address1' => $params['shippingaddress1'],
                'address2' => $params['shippingaddress2'],
                'address3' => $params['shippingaddress3'],
                'city' => $params['shippingcity'],
                'state' => $params['shippingstate'],
                'postcode' => $params['shippingpostcode'],
                'countryId' => $params['shippingcountryId']
            ];
            $shippingAddress = new Address($data);
        }

        if (isset($params['billingAddressSameAsShipping']))
        {
            $billingAddress = $shippingAddress;
        }
        else
        {
            if (isset($params['billingAddressId']))
            {
                $billingAddress = new Address(['id' => $params['billingAddressId']]);
            }
            else
            {
                $data = [
                    'address1' => $params['billingaddress1'],
                    'address2' => $params['billingaddress2'],
                    'address3' => $params['billingaddress3'],
                    'city' => $params['billingcity'],
                    'state' => $params['billingstate'],
                    'postcode' => $params['billingpostcode'],
                    'countryId' => $params['billingcountryId']
                ];
                $billingAddress = new Address($data);
            }
        }

        if (isset($params['billingAddressSameAsShipping'])) $data['billing_address_same_as_shipping'] = true;

        $items = [];
        foreach ($cart->getItems() as $item)
        {
            /* @var $item CartItem */
            $sku = $item->getProduct()->product_sku . $item->getProductVariation()->variation_sku;

            for ($i = 1; $i <= $item->getQuantity(); $i++)
            {
                $items[] = new OrderItem(NULL, $item->getProductVariation()->id, $item->getTaxRate(), $item->singleItemPrice(), $item->getProduct()->product_name, $sku, 0, 0);
            }
        }

        return new Order($customer, $billingAddress, $shippingAddress, $items, $cart->getShippingType());
    }

    /**
     * @param $order
     * @return Order
     */
    public function fromApi($order)
    {
        $billingAddress = new Address([
            'address1' => $order->billing_address->address1,
            'address2' => $order->billing_address->address2,
            'address3' => $order->billing_address->address3,
            'city' => $order->billing_address->city,
            'state' => $order->billing_address->state,
            'postcode' => $order->billing_address->postcode,
            'countryId' => $order->billing_address->country_id,
        ]);

        $shippingAddress = new Address([
            'address1' => $order->shipping_address->address1,
            'address2' => $order->shipping_address->address2,
            'address3' => $order->shipping_address->address3,
            'city' => $order->shipping_address->city,
            'state' => $order->shipping_address->state,
            'postcode' => $order->shipping_address->postcode,
            'countryId' => $order->shipping_address->country_id,
        ]);

        $customer = new Customer($order->customer_id, new Name($order->customer_id ? $order->customer->full_name : $order->guest_full_name));
        $customer->setJobRole($order->customer_id ? $order->customer->jobrole : $order->guest_jobrole);
        $customer->setPrimaryEmail($order->customer_id ? $order->customer->primary_email : $order->guest_email);
        $customer->setCompanyName($order->customer_id ? $order->customer->company_name : $order->guest_company_name);
        $customer->setTaxNumber($order->customer_id ? $order->customer->tax_number : $order->guest_tax_number);

        $items = [];
        foreach ($order->items as $item)
        {
            $items[] = new OrderItem($item->id, $item->product_variation_id, $item->tax_rate, $item->price, $item->product_name, $item->product_sku, $item->is_shipping, $item->discount_amount);
        }

        return new Order($customer, $billingAddress, $shippingAddress, $items, null, $order->id);
    }

}