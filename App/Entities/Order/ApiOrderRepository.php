<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;

class ApiOrderRepository implements OrderRepository {

    /**
     * @param $id
     * @return Order
     */
    public function getOrder($id)
    {
        // TODO: Implement getOrder() method.
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function saveOrder($order)
    {
        $params = [

        ];

        VendirunApi::makeRequest('order/create', $params);
    }

}