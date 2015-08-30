<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Base\AbstractVendirunResponse;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Base\VendirunResponse;

class VendirunResponseV1 extends AbstractVendirunResponse implements VendirunResponse {

    /**
     * @param $raw
     */
    public function __construct($raw)
    {
        $this->success = $raw->success;
        $this->data = $this->success ? $raw->data : [];
        $this->error = $this->success ? '' : $raw->data;
    }

}