<?php namespace AlistairShaw\Vendirun\App\Lib\PaymentGateway\Exceptions;

class CardDeclinedException extends PaymentGatewayException {

    public function __construct()
    {
        parent::__construct(trans('vendirun::checkout.cardDeclined'));
    }

}