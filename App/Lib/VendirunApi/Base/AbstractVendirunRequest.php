<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Base;

abstract class AbstractVendirunRequest implements VendirunRequest {

    /**
     * @var VendirunResponse
     */
    protected $response;

    /**
     * @return VendirunResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}