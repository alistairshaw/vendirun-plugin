<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions;

use App;

class InvalidResponseException extends VendirunApiException {

    public function __construct($availableInCache, $url, $key)
    {
        $message = sprintf('Invalid API Response from Endpoint "%s", returned invalid JSON.', $url);
        $this->alertSupport($message, $key);

        // only stop the script from executing if the value is NOT available from the cache
        if (!$availableInCache) parent::__construct($message);
    }

}