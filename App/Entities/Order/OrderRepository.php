<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

interface OrderRepository {

    /**
     * @param $id
     * @return Order
     */
    public function getOrder($id);

    /**
     * @param Order $order
     * @return bool
     */
    public function saveOrder($order);

}