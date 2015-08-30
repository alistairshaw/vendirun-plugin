<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Base;

abstract class AbstractVendirunResponse implements VendirunResponse {

    /**
     * @var bool
     */
    protected $success;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $error;

    /**
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}