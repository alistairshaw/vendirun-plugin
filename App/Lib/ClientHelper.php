<?php namespace AlistairShaw\Vendirun\App\Lib;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Config;

class ClientHelper {

    /**
     * @return object
     */
    public static function getClientInfo()
    {
        if (Config::get('clientInfo')) return Config::get('clientInfo');

        $clientInfo = VendirunApi::makeRequest('client/publicInfo')->getData();
        Config::set('clientInfo', $clientInfo);

        return $clientInfo;
    }

    /**
     * @param string $gateway
     * @return object
     */
    public static function getPaymentGatewayInfo($gateway = '')
    {
        $paymentGateways = VendirunApi::makeRequest('client/paymentGateways')->getData();
        $data['stripe'] = false;
        $data['paypal'] = false;
        foreach ($paymentGateways as $key => $settings)
        {
            if ($gateway == $key) return $settings;

            $data[$key] = true;
            $data[$key . 'Settings'] = $settings;
        }

        return (object)$data;
    }

}