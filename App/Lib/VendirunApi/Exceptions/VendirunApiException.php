<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions;

use Cache;
use Log;
use Mail;

class VendirunApiException extends \Exception {

    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

}