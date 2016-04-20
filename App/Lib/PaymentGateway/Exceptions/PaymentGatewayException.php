<?php namespace AlistairShaw\Vendirun\App\Lib\PaymentGateway\Exceptions;

class PaymentGatewayException extends \Exception {

    /**
     * PaymentGatewayException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct(trans('vendirun::checkout.paymentTakenOtherError') . ' - ' . $message);
    }

}