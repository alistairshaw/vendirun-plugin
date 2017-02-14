<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\InvalidApiRequestException;

class OrderApi extends BaseApi {

    /**
     * @param $params
     * @return object
     */
    public function search($params)
    {
        $url = 'order/search';

        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return object
     * @throws InvalidApiRequestException
     * @throws \AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException
     */
    public function store($params)
    {
        if (isset($params['id'])) throw new InvalidApiRequestException('Only use store to save a new order, use update to update it');

        $url = 'order/store';

        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     * @throws InvalidApiRequestException
     * @throws \AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException
     */
    public function update($params)
    {
        if (!isset($params['id'])) throw new InvalidApiRequestException('Update must have an ID');

        $url = 'order/update/' . $params['id'];
        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return object
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

    /**
     * @param $params
     * @return object
     */
    public function download($params)
    {
        $url = 'order/downloadable/';
        $url .= (isset($params['orderId'])) ? $params['orderId'] : '0';
        if (isset($params['fileId'])) $url .= '/' . $params['fileId'];

        return $this->request($url, $params);
    }
}