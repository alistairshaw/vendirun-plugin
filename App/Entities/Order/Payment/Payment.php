<?php namespace AlistairShaw\Vendirun\App\Entities\Order\Payment;

use AlistairShaw\Vendirun\App\Entities\Order\Order;

class Payment {

    /**
     * @var Order
     */
    private $order;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $paymentDate;

    /**
     * @var string
     */
    private $paymentType;

    /**
     * @var string
     */
    private $transactionData;

    /**
     * Payment constructor.
     * @param Order  $order
     * @param int    $amount
     * @param string $paymentDate
     * @param string $paymentType
     * @param string $transactionData
     */
    public function __construct(Order $order, $amount, $paymentDate, $paymentType = '', $transactionData = '')
    {
        $this->order = $order;
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
        $this->paymentType = $paymentType;
        $this->transactionData = $transactionData;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return [
            'orderId' => $this->order->getId(),
            'amount' => $this->amount,
            'paymentDate' => $this->paymentDate,
            'transactionData' => $this->transactionData,
            'paymentType' => $this->paymentType
        ];
    }

}