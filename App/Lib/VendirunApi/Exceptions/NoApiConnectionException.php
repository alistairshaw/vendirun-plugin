<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions;

class NoApiConnectionException extends VendirunApiException
{
    public function __construct($url, $statusCode, $key)
    {
        $message = sprintf('Unable to connect to the API at Endpoint "%s", returned Status Code of "%s".', $url, $statusCode);
        $this->alertSupport($message, $key);
        parent::__construct($message);
    }
}