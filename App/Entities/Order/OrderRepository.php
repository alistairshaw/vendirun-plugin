<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

interface OrderRepository {

    /**
     * @param        $id
     * @param string $oneTimeToken
     * @return Order
     */
    public function find($id, $oneTimeToken = '');

    /**
     * @param Order $order
     * @return Order
     */
    public function save(Order $order);

}