<?php namespace AlistairShaw\Vendirun\App\Entities\Order\OrderSearchResult;

class OrderSearchResult {

    /**
     * Array of order objects
     * @var array
     */
    private $orders;

    /**
     * @var int
     */
    private $totalRows;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var string
     */
    private $search;

    /**
     * OrderSearchResult constructor.
     * @param $orders
     * @param $totalRows
     * @param $search
     * @param $limit
     * @param $offset
     */
    public function __construct($orders, $totalRows, $search, $limit, $offset)
    {
        $this->orders = $orders;
        $this->totalRows = $totalRows;
        $this->search = $search;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getTotalRows()
    {
        return $this->totalRows;
    }

    /**
     * @return array
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

}