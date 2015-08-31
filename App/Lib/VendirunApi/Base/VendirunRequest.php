<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Base;

interface VendirunRequest {

    /**
     * @return VendirunResponse
     */
    public function getResponse();

}