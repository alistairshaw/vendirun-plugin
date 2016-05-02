<?php namespace AlistairShaw\Vendirun\App\Entities\Order;

use AlistairShaw\Vendirun\App\Entities\Order\OrderSearchResult\OrderSearchResult;

interface OrderRepository {

    /**
     * @param $customerToken
     * @param string $search
     * @param int $limit
     * @param int $perPage
     * @return OrderSearchResult
     */
    public function search($customerToken, $search = '', $limit = 1, $perPage = 10);

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