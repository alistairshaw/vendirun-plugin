<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions;

use AlistairShaw\Vendirun\App\Traits\NotifySupportTrait;
use App;

class FailResponseException extends VendirunApiException {

    use NotifySupportTrait;

    public function __construct($availableInCache, $url, $key)
    {
        $notice = sprintf('API Responded with failure at Endpoint "%s"', $url);
        $this->alertSupport($notice, $key);

        // only stop the script from executing if the value is NOT available from the cache
        if (!$availableInCache)
        {
            parent::__construct($notice, 404);
        }
    }

}