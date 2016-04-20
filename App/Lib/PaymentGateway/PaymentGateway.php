<?php namespace AlistairShaw\Vendirun\App\Lib\PaymentGateway;

interface PaymentGateway {

    /**
     * @return string url to redirect to, or an empty string for payment accepted
     */
    public function takePayment();

    /**
     * @param array $params
     * @return mixed
     */
    public function confirmPayment($params = []);

}