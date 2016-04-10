<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;

class CartApi extends BaseApi {

    /**
     * @param array $params
     * @return object
     * @throws FailResponseException
     */
    public function add($params)
    {
        $url = 'cart/add/' . $params['productVariationId'] . '/' . $params['quantity'];

        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function current($params)
    {
        $url = 'cart/current';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function update($params)
    {
        $url = 'cart/update';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function fetch($params)
    {
        $url = 'cart/index';
        return $this->request($url, $params, true);
    }
} 