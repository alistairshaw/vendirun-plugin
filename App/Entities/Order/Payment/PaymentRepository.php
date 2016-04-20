<?php namespace AlistairShaw\Vendirun\App\Entities\Order\Payment;

interface PaymentRepository {

    /**
     * @param $id
     * @return Payment
     */
    public function find($id);

    /**
     * @param Payment $payment
     * @return Payment
     */
    public function save(Payment $payment);

}