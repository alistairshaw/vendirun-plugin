<?php namespace AlistairShaw\Vendirun\App\Entities\Order\Payment;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;

class ApiPaymentRepository implements PaymentRepository {

    /**
     * @param $id
     * @return Payment
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param Payment $payment
     * @return Payment
     */
    public function save(Payment $payment)
    {
        $paymentArray = $payment->getArray();
        $params = [
            'order_id' => $paymentArray['orderId'],
            'payment_amount' => $paymentArray['amount'],
            'payment_date' => $paymentArray['paymentDate'],
            'payment_type' => $paymentArray['paymentType'],
            'transaction_data' => $paymentArray['transactionData']
        ];

        VendirunApi::makeRequest('order/payment', $params);
    }
}