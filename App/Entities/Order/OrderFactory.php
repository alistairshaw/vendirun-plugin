<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\ValueObjects\Address;

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
     * @param Cart $cart
     * @return Order
     */
    public function fromCart(Cart $cart, $params)
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
                'country_id' => $params['shippingcountryId']
            ];
            $shippingAddress = new Address($data);
        }

        if (isset($params['billingAddressId']) && !isset($params['billingAddressSameAsShipping']))
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
                'country_id' => $params['billingcountryId']
            ];
            $billingAddress = new Address($data);
        }

        if (isset($params['billingAddressSameAsShipping'])) $data['billing_address_same_as_shipping'] = true;
        
        $items = [];
        foreach ($cart->getItems() as $item)
        {
            $sku = $item->getProduct()->product_sku . $item->getVariation()->variation_sku;

            for ($i = 1; $i <= $item->quantity(); $i++)
            {
                $items[] = new OrderItem(null, $item->getTaxRate(), $item->singleItemPrice(), $item->getProduct()->product_name, $sku, 0, 0);
            }
        }

        return new Order($billingAddress, $shippingAddress, $items);
    }

}