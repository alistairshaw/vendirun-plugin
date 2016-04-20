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
     * @var Cart
     */
    protected $cart;

    /**
     * @var CartRepository
     */
    protected $cartRepository;

    /**
     * AbstractPaymentGateway constructor.
     * @param Order             $order
     * @param Cart              $cart
     * @param CartRepository    $cartRepository
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(Order $order, Cart $cart = null, CartRepository $cartRepository = null, PaymentRepository $paymentRepository = null)
    {
        $this->order = $order;
        $this->paymentRepository = $paymentRepository;
        $this->cart = $cart;
        $this->cartRepository = $cartRepository;
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