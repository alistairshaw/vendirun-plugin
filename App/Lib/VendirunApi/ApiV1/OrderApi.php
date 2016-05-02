<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

class OrderApi extends BaseApi {

    /**
     * @param $params
     * @return array
     */
    public function search($params)
    {
        $url = 'order/search';

        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function store($params)
    {
        $url = 'order/store';

        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function find($params)
    {
        $url = 'order/find';
        if (isset($params['id'])) $url .= '/' . $params['id'];

        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     * @throws \AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException
     */
    public function payment($params)
    {
        $url = 'order/payment';

        return $this->request($url, $params);
    }
}