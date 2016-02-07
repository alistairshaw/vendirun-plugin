<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;

class PropertyApi extends BaseApi {

    /**
     * @param $params
     * @return object
     */
    function search($params)
    {
        $url = 'property/search';
        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     */
    public function property($params)
    {
        $url = 'property/find';
        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     */
    public function addToFavourite($params)
    {
        $url = 'property/add_favourite';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     */
    public function removeFavourite($params)
    {
        $url = 'property/remove_favourite';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return array
     */
    public function getFavourite($params)
    {
        $url = 'property/get_favourite';
        return $this->request($url, $params, true);
    }

    /**
     * @param array $params
     * @return object
     */
    public function getLocation($params)
    {
        $url = 'property/location';
        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getCategory($params)
    {
        $url = 'property/category';
        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getCategoryList($params = [])
    {
        $url = 'property/category_list';
        return $this->request($url, $params);
    }
} 