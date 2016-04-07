<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;

class ProductApi extends BaseApi {

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    function search($params)
    {
        $url = 'product/search';

        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function property($params)
    {
        $url = 'product/find';

        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function category($params)
    {
        $url = 'product/category';

        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function colors($params)
    {
        $url = 'product/colors';

        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function sizes($params)
    {
        $url = 'product/sizes';

        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function types($params)
    {
        $url = 'product/types';

        return $this->request($url, $params);
    }

} 