<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\Base;

interface VendirunResponse {

    /**
     * @return bool
     */
    public function getSuccess();

    /**
     * @return object
     */
    public function getData();

    /**
     * @return string
     */
    public function getError();
}