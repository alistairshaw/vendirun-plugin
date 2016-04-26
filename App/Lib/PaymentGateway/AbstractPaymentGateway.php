<?php namespace AlistairShaw\Vendirun\App\Lib\PaymentGateway;

use AlistairShaw\Vendirun\App\Entities\Cart\Cart;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Order\Order;
use AlistairShaw\Vendirun\App\Entities\Order\Payment\PaymentRepository;

abstract class AbstractPaymentGateway implements PaymentGateway {

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    /**
     * AbstractPaymentGateway constructor.
     * @param Order             $order
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(Order $order, PaymentRepository $paymentRepository = null)
    {
        $this->order = $order;
        $this->paymentRepository = $paymentRepository;
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