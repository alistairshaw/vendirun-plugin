<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1\VendirunRequestV1;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Base\VendirunResponse;

/**
 * This is a FACTORY class to make and return the objects based on what
 *   Version we are using.
 * @package AlistairShaw\Vendirun\App\Lib\VendirunApi\Base
 */
class VendirunApi {

    /**
     * @param string $request
     * @param array  $parameters
     * @return VendirunResponse
     */
    public static function makeRequest($request, $parameters = [])
    {
        $request = new VendirunRequestV1($request, $parameters);
        return $request->getResponse();
    }

}