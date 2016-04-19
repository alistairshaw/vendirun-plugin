<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

class ClientApi extends BaseApi {

    /**
     * @return array
     */
    public function publicInfo()
    {
        $url = 'client';

        return $this->request($url, [], false, 60);
    }

    /**
     * @return object
     * @throws \AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException
     */
    public function paymentGateways()
    {
        $url = 'client/payment_gateways';

        return $this->request($url, []);
    }

    /**
     * @param array $params
     * @return array
     * @throws \AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException
     */
    public function staff($params = [])
    {
        $url = 'client/staff';

        return $this->request($url, $params, false, 60);
    }

}