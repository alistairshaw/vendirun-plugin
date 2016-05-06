<?php namespace AlistairShaw\Vendirun\App\Lib\PaymentGateway;

use AlistairShaw\Vendirun\App\Entities\Order\Order;
use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;

abstract class AbstractPaymentGateway implements PaymentGateway {

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * AbstractPaymentGateway constructor.
     * @param Order             $order
     * @param OrderRepository $orderRepository
     */
    public function __construct(Order $order, OrderRepository $orderRepository = null)
    {
        $this->order = $order;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param array $params
     * @return bool
     */
    public function confirmPayment($params = [])
    {
        // returns true by default, payment is confirmed in the takePayment method
        return true;
    }

}