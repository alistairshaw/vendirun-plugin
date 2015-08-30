<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions;

use AlistairShaw\Vendirun\App\Traits\NotifySupportTrait;

class NoApiConnectionException extends VendirunApiException
{
    use NotifySupportTrait;

    public function __construct($url, $statusCode, $key)
    {
        $message = sprintf('Unable to connect to the API at Endpoint "%s", returned Status Code of "%s".', $url, $statusCode);
        $this->alertSupport($message, $key);
        parent::__construct($message);
    }
}