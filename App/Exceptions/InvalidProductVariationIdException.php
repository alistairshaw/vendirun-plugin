<?php namespace AlistairShaw\Vendirun\App\Exceptions;

class InvalidProductVariationIdException extends VendirunException {

    /**
     * InvalidProductVariationIdException constructor.
     * @param string $notice
     */
    public function __construct($notice)
    {
        parent::__construct($notice);
    }

}