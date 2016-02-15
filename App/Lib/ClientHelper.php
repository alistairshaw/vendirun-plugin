<?php namespace AlistairShaw\Vendirun\App\Lib;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Config;

class ClientHelper {

    public static function getClientInfo()
    {
        if (Config::get('clientInfo')) return Config::get('clientInfo');

        $clientInfo = VendirunApi::makeRequest('client/publicInfo')->getData();
        Config::set('clientInfo', $clientInfo);

        return $clientInfo;
    }

}