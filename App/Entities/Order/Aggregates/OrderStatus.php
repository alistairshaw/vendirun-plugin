<?php namespace AlistairShaw\Vendirun\App\Entities\Order\Aggregates;

class OrderStatus {

    /**
     * @var string
     */
    private $created;

    /**
     * @var bool
     */
    private $is_paid;

    /**
     * @var string
     */
    private $completed_at;

    /**
     * @var string
     */
    private $cancelled_at;

    /**
     * @var string
     */
    private $cancellation_reason;

    /**
     * @var bool
     */
    private $fully_shipped;

    /**
     * @var bool
     */
    private $partially_shipped;

    /**
     * @var string
     */
    private $shipped_at;

    /**
     * OrderStatus constructor.
     * @param $created
     * @param bool $is_paid
     * @param string $completed_at
     * @param string $cancelled_at
     * @param string $cancellation_reason
     * @param bool $fully_shipped
     * @param bool $partially_shipped
     * @param string $shipped_at
     * @internal param bool $shipped
     */
    public function __construct($created, $is_paid = false, $completed_at = null, $cancelled_at = null, $cancellation_reason = null, $fully_shipped = false, $partially_shipped = false, $shipped_at = null)
    {
        $this->created = $created;
        $this->is_paid = (bool)$is_paid;
        $this->completed_at = $completed_at;
        $this->cancelled_at = $cancelled_at;
        $this->cancellation_reason = $cancellation_reason;
        $this->fully_shipped = (bool)$fully_shipped;
        $this->partially_shipped = (bool)$partially_shipped;
        $this->shipped_at = $shipped_at;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        $status = trans('vendirun::orders.statusPendingPayment');
        if ($this->is_paid) $status = trans('vendirun::orders.statusPendingShipment');
        if ($this->partially_shipped) $status = trans('vendirun::orders.statusPartiallyShipped');
        if ($this->fully_shipped) $status = trans('vendirun::orders.statusShipped');
        if ($this->fully_shipped && $this->is_paid) $status = trans('vendirun::orders.statusPendingCompletion');
        if ($this->completed_at) $status = trans('vendirun::orders.statusCompleted');

        return $status;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }
}