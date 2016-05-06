<?php namespace AlistairShaw\Vendirun\App\Entities\Order\OrderSearchResult;

use AlistairShaw\Vendirun\App\Entities\Order\OrderFactory;

class OrderSearchResultFactory {

    /**
     * @param $result
     * @return OrderSearchResult
     */
    public function fromApi($result)
    {
        $orderFactory = new OrderFactory();
        $orders = [];
        foreach ($result->result as $order) $orders[] = $orderFactory->fromApi($order);

        return new OrderSearchResult($orders, $result->count, $result->search, $result->limit, $result->offset);
    }

    /**
     * @return OrderSearchResult
     */
    public function emptyResult()
    {
        return new OrderSearchResult([], 0, '', 0, 0);
    }

}