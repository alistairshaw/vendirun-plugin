<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Session;

class ApiOrderRepository implements OrderRepository {

    /**
     * @param $id
     * @return Order
     */
    public function getOrder($id = null)
    {
        $params = [
            'id' => $id,
            'one_time_token' => Session::get('orderOneTimeToken'),
            'token' => Session::get('token')
        ];

        try
        {
            $orderFactory = new OrderFactory($this);
            return $orderFactory->fromApi(VendirunApi::makeRequest('order/find', $params)->getData());
        }
        catch (FailResponseException $e)
        {
            return false;
        }
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function saveOrder(Order $order)
    {
        $products = [];
        foreach ($order->getItems() as $item)
        {
            /* @var $item OrderItem */
            $products[] =  $item->getProductVariationId();
        }

        $params = [
            'id' => $order->getId(),
            'full_name' => $order->getCustomer()->fullName(),
            'company_name' => $order->getCustomer()->getCompanyName(),
            'jobrole' => $order->getCustomer()->getJobRole(),
            'email' => $order->getCustomer()->getPrimaryEmail(),
            'email_subscribe' => true,
            'shipping_address_id' => $order->getShippingAddress()->getId(),
            'shipping_address1' => $order->getShippingAddress()->getArray()['address1'],
            'shipping_address2' => $order->getShippingAddress()->getArray()['address2'],
            'shipping_address3' => $order->getShippingAddress()->getArray()['address3'],
            'shipping_city' => $order->getShippingAddress()->getArray()['city'],
            'shipping_state' => $order->getShippingAddress()->getArray()['state'],
            'shipping_postcode' => $order->getShippingAddress()->getArray()['postcode'],
            'shipping_country_id' => $order->getShippingAddress()->getArray()['countryId'],
            'billing_address_id' => $order->getBillingAddress()->getId(),
            'billing_address1' => $order->getBillingAddress()->getArray()['address1'],
            'billing_address2' => $order->getBillingAddress()->getArray()['address2'],
            'billing_address3' => $order->getBillingAddress()->getArray()['address3'],
            'billing_city' => $order->getBillingAddress()->getArray()['city'],
            'billing_state' => $order->getBillingAddress()->getArray()['state'],
            'billing_postcode' => $order->getBillingAddress()->getArray()['postcode'],
            'billing_country_id' => $order->getBillingAddress()->getArray()['countryId'],
            'billing_address_same_as_shipping' => $order->getBillingAddress()->isEqualTo($order->getShippingAddress()),
            'products' => $products,
            'shipping_type' => $order->getShippingType()
        ];

        $result = VendirunApi::makeRequest('order/store', $params)->getData();

        Session::set('orderOneTimeToken', $result->one_time_token);

        return $this->getOrder($result->order_id);
    }

}