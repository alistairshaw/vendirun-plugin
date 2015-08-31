<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions;

use AlistairShaw\Vendirun\App\Traits\NotifySupportTrait;
use App;

class FailResponseException extends VendirunApiException {

    use NotifySupportTrait;

    public function __construct($availableInCache, $notice)
    {
        // only stop the script from executing if the value is NOT available from the cache
        if (!$availableInCache)
        {
            parent::__construct($notice, 404);
        }
    }

}