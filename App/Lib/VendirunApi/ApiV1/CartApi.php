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

        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function current($params)
    {
        $url = 'cart/current';
        return $this->request($url, $params);
    }
} 