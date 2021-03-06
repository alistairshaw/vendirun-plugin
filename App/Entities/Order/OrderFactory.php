<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\Transformers\CartItemValuesTransformer;
use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesTransformer;
use AlistairShaw\Vendirun\App\Entities\Customer\Customer;
use AlistairShaw\Vendirun\App\Entities\Order\Aggregates\OrderStatus;
use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\Downloadable;
use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\Entities\Order\Payment\Payment;
use AlistairShaw\Vendirun\App\Entities\Order\Shipment\ShipmentFactory;
use AlistairShaw\Vendirun\App\ValueObjects\Address;
use AlistairShaw\Vendirun\App\ValueObjects\Name;

class OrderFactory {

    /**
     * @param Cart $cart
     * @param Customer $customer
     * @param CartValuesTransformer $cartValuesTransformer
     * @param CartItemValuesTransformer $cartItemValuesTransformer
     * @param array $params
     * @return Order
     */
    public function fromCart(Cart $cart, Customer $customer, CartValuesTransformer $cartValuesTransformer, CartItemValuesTransformer $cartItemValuesTransformer, $params)
    {
        if (isset($params['shippingaddressId']) && $params['shippingaddressId'] > 0)
        {
            $shippingAddress = $customer->getAddressFromAddressId($params['shippingaddressId']);
        }
        elseif (isset($params['shippingaddress1']))
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
        else
        {
            $shippingAddress = null;
        }

        if (isset($params['billingAddressSameAsShipping']) && $params['billingAddressSameAsShipping'])
        {
            $billingAddress = $shippingAddress;
            $data['billing_address_same_as_shipping'] = true;
        }
        else
        {
            if (isset($params['billingaddressId']) && $params['billingaddressId'] > 0)
            {
                $billingAddress = $customer->getAddressFromAddressId($params['billingaddressId']);
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

                if ($shippingAddress === null)
                {
                    $shippingAddress = $billingAddress;
                    $data['billing_address_same_as_shipping'] = true;
                }
            }
        }

        if (isset($params['billingAddressSameAsShipping'])) $data['billing_address_same_as_shipping'] = true;

        $items = [];
        foreach ($cart->getItems() as $item)
        {
            /* @var $item CartItem */
            $sku = $item->getSku();

            $cartItemValues = $item->getValues($cartItemValuesTransformer);

            $items[] = new OrderItem(NULL, $item->getVariationId(), $item->getTaxRate(), $cartItemValues['totalBeforeTax'], $item->getQuantity(), $item->getProductName(), $sku, 0, 0);
        }

        // add order item for shipping
        $cartValues = $cart->getValues($cartValuesTransformer);

        if ($cartValues['shipping'] !== null) $items[] = new OrderItem(NULL, NULL, $cart->getDefaultTaxRate(), $cartValues['shipping'] - $cartValues['shippingTax'], 1, $cart->getShippingType(), 'SHIPPING', 1, 0);

        $order = new Order($customer, $billingAddress, $shippingAddress, $items, $cart->getShippingType());

        return $order;
    }

    /**
     * @param $order
     * @return Order
     */
    public function fromApi($order)
    {
        $billingAddress = new Address([
            'id' => $order->billing_address->id,
            'address1' => $order->billing_address->address1,
            'address2' => $order->billing_address->address2,
            'address3' => $order->billing_address->address3,
            'city' => $order->billing_address->city,
            'state' => $order->billing_address->state,
            'postcode' => $order->billing_address->postcode,
            'countryId' => $order->billing_address->country_id,
        ]);

        $shippingAddress = new Address([
            'id' => $order->shipping_address->id,
            'address1' => $order->shipping_address->address1,
            'address2' => $order->shipping_address->address2,
            'address3' => $order->shipping_address->address3,
            'city' => $order->shipping_address->city,
            'state' => $order->shipping_address->state,
            'postcode' => $order->shipping_address->postcode,
            'countryId' => $order->shipping_address->country_id,
        ]);

        // customer
        $customer = new Customer($order->customer_id, Name::fromFullName($order->customer_id ? $order->customer->fullname : $order->guest_full_name));
        $customer->setJobRole($order->customer_id ? $order->customer->jobrole : $order->guest_jobrole);
        $customer->setPrimaryEmail($order->customer_id ? $order->customer->primary_email : $order->guest_email);
        $customer->setCompanyName($order->customer_id ? $order->customer->organisation_name : $order->guest_company_name);
        $customer->setTaxNumber($order->customer_id ? $order->customer->tax_number : $order->guest_tax_number);

        // order items
        $items = [];
        foreach ($order->items as $item)
        {
            $orderItem = new OrderItem($item->id, $item->product_variation_id, $item->tax_rate, $item->price, $item->quantity, $item->product_name, $item->product_sku, $item->is_shipping, $item->discount_amount);
            foreach ($item->downloadables as $downloadable)
            {
                $orderItem->addDownloadable(new Downloadable($downloadable->id, $downloadable->filename, $downloadable->file_size));
            }
            $items[] = $orderItem;
        }

        $orderStatus = new OrderStatus($order->created, $order->is_paid, $order->completed_at, $order->cancelled_at, $order->cancellation_reason, $order->fully_shipped, $order->partially_shipped, $order->shipped_at);

        $vrOrder = new Order($customer, $billingAddress, $shippingAddress, $items, null, $order->id, $orderStatus);

        // add the payments
        foreach ($order->payments as $payment)
        {
            $vrOrder->addPayment(new Payment($payment->payment_amount, $payment->created, $payment->payment_type, $payment->transaction_data, $payment->id));
        }

        // shipments
        $shipmentFactory = new ShipmentFactory();
        foreach ($order->shipments as $shipment) $vrOrder->addShipment($shipmentFactory->fromApi($shipment, $vrOrder));

        return $vrOrder;
    }

}