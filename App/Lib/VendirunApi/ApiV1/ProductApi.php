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
    public function product($params)
    {
        $url = 'product';

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

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function favourites($params)
    {
        $url = 'product/get_favourites';
        
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function addFavourite($params)
    {
        $url = 'product/add_favourite';
        
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function removeFavourite($params)
    {
        $url = 'product/remove_favourite';

        return $this->request($url, $params, true);
    }

} 