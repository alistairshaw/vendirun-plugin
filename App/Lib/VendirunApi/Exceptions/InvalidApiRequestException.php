<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions;

class InvalidApiRequestException extends VendirunApiException {

    public function __construct($url)
    {
        $message = sprintf('Invalid API Endpoint "%s"', $url);
        parent::__construct($message);
    }

}