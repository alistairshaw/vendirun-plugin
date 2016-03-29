<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;

class ProductApi extends BaseApi {

    /**
     * @param $params
     * @return object
     */
    function search($params)
    {
        $url = 'product/search';
        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     */
    public function property($params)
    {
        $url = 'product/find';
        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getCategory($params)
    {
        $url = 'product/category';
        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getCategoryList($params = [])
    {
        $url = 'product/category_list';
        return $this->request($url, $params);
    }
} 