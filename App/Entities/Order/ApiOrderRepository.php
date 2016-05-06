<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Entities\Order\OrderItem\OrderItem;
use AlistairShaw\Vendirun\App\Entities\Order\OrderSearchResult\OrderSearchResult;
use AlistairShaw\Vendirun\App\Entities\Order\OrderSearchResult\OrderSearchResultFactory;
use AlistairShaw\Vendirun\App\Entities\Order\Payment\Payment;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;

class ApiOrderRepository implements OrderRepository {

    /**
     * @param $customerToken
     * @param string $search
     * @param int $limit
     * @param int $offset
     * @return OrderSearchResult
     */
    public function search($customerToken, $search = '', $limit = 0, $offset = 10)
    {
        $orderSearchResultFactory = new OrderSearchResultFactory();
        try
        {
            $searchOptions = [
                'token' => $customerToken,
                'search' => $search,
                'limit' => $limit,
                'offset' => $offset
            ];

            return $orderSearchResultFactory->fromApi(VendirunApi::makeRequest('order/search', $searchOptions)->getData());
        }
        catch (FailResponseException $e)
        {
            return $orderSearchResultFactory->emptyResult();
        }
    }

    /**
     * @param      $id
     * @param null $oneTimeToken
     * @param bool $removeOneTimeToken
     * @return Order
     */
    public function find($id = null, $oneTimeToken = null, $removeOneTimeToken = true)
    {
        $params = [
            'id' => $id,
            'token' => CustomerHelper::checkLoggedinCustomer(),
            'remove_one_time_token' => $removeOneTimeToken
        ];

        try
        {
            $orderFactory = new OrderFactory();
            $apiResult = VendirunApi::makeRequest('order/find', $params)->getData();

            $order = $orderFactory->fromApi($apiResult);

            $order->setOneTimeToken($oneTimeToken);

            return $order;
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
    public function save(Order $order)
    {
        if ($order->getId()) return $this->update($order);

        $products = [];
        $items = [];
        foreach ($order->getItems() as $item)
        {
            /* @var $item OrderItem */
            $products[] =  $item->getProductVariationId();
            $items[] = [
                'product_variation_id' => $item->getProductVariationId(),
                'product_name' => $item->getProductName(),
                'product_sku' => $item->getProductSku(),
                'price' => $item->getPrice(),
                'tax_rate' => $item->getTaxRate(),
                'is_shipping' => $item->isShipping()
            ];
        }

        $params = [
            'customer_id' => $order->getCustomer()->getId(),
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
            'shipping_type' => $order->getShippingType(),
            'items' => $items,
            'payments' => $this->compose_payments($order)
        ];

        $result = VendirunApi::makeRequest('order/store', $params)->getData();

        return $this->find($result->order_id, $result->one_time_token, false);
    }

    /**
     * Update only sends payment details as you cannot edit anything else on an
     *   order from the front-end
     * @param Order $order
     * @return Order
     */
    private function update(Order $order)
    {
        $params = [
            'id' => $order->getId(),
            'payments' => $this->compose_payments($order)
        ];

        $result = VendirunApi::makeRequest('order/update', $params)->getData();

        return $this->find($result->order_id, false);
    }

    /**
     * @param Order $order
     * @return array
     */
    private function compose_payments(Order $order)
    {
        $payments = [];
        foreach ($order->getPayments() as $payment)
        {
            /* @var $payment Payment */
            $pd = $payment->getArray();
            $payments[] = [
                'id' => $payment->getId(),
                'payment_amount' => $pd['amount'],
                'payment_date' => $pd['paymentDate'],
                'transaction_data' => $pd['transactionData'],
                'payment_type' => $pd['paymentType']
            ];
        }

        return $payments;
    }

}