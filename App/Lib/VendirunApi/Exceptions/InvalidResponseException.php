<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions;

use AlistairShaw\Vendirun\App\Traits\NotifySupportTrait;
use App;

class InvalidResponseException extends VendirunApiException {

    use NotifySupportTrait;

    public function __construct($availableInCache, $url, $key)
    {
        $message = sprintf('Invalid API Response from Endpoint "%s", returned invalid JSON.', $url);
        $this->alertSupport($message, $key);

        // only stop the script from executing if the value is NOT available from the cache
        if (!$availableInCache) parent::__construct($message);
    }

}