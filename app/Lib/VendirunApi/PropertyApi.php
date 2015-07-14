<?php namespace Ambitiousdigital\Vendirun\App\Lib\VendirunApi;

class PropertyApi extends BaseApi {

    /**
     * @param $searchArray
     * @return array
     */
    function search($searchArray)
    {
        $url = 'property/search';
        $this->request($url, $searchArray);
        $response = $this->getResult();

        return ($response['success']) ? $response['data'] : false;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function property($params)
    {
        $url = 'property/find';
        $this->request($url, $params);

        $response = $this->getResult();

        return ($response['success']) ? $response['data'] : false;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function addToFavourite($params)
    {
        $url = 'property/add_favourite';
        $this->request($url, $params, true);

        return $this->getResult();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function removeFavourite($params)
    {
        $url = 'property/remove_favourite';
        $this->request($url, $params, true);

        return $this->getResult();
    }

    /**
     * @param string $token
     * @param bool   $idsOnly
     * @return array
     */
    public function getFavourite($token, $idsOnly = false)
    {
        if (!$token) return [];

        $url = 'property/get_favourite';
        $this->request($url, $token, true);
        $response = $this->getResult();

        $favourites = ($response['success']) ? $response['data'] : [];
        if (!$idsOnly) return $favourites;

        $favouriteIds = [];
        foreach ($favourites as $favourite)
        {
            $favouriteIds[] = $favourite->id;
        }

        return $favouriteIds;
    }

    /**
     * @param     $locationName
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getLocation($locationName, $limit = 0, $offset = 0)
    {
        $url = 'property/location';
        $this->request($url, ['location' => $locationName, 'limit' => $limit, 'offset' => $offset], true);

        return $this->getResult();
    }

    /**
     * @param     $categoryName
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getCategory($categoryName = '', $limit = 0, $offset = 0)
    {
        $url = 'property/category';
        $this->request($url, ['category' => $categoryName, 'limit' => $limit, 'offset' => $offset], true);

        return $this->getResult();
    }

    /**
     * @return array
     */
    public function getCategoryList()
    {
        $url = 'property/category_list';
        $this->request($url);

        return $this->getResult();
    }

    /**
     * @param        $categories
     * @param string $parent_name
     * @return array
     */
    private function arrangeCategories($categories, $parent_name = '')
    {
        $finalArray = array();

        if ($categories && count($categories) > 0)
        {
            foreach ($categories as $row)
            {
                $tempArray['id'] = $row->id;
                $tempArray['category_name'] = ($parent_name != '') ? $parent_name . ' > ' . $row->category_name : $row->category_name;
                $tempArray['category_description'] = $row->category_description;
                $tempArray['primary_image'] = $row->primary_image;
                $finalArray[] = $tempArray;
                if (count($row->sub_categories) > 0)
                {
                    $childArray = $this->arrangeCategories($row->sub_categories, $tempArray['category_name']);
                    $finalArray = array_merge($finalArray, $childArray);
                }

            }
        }

        return $finalArray;
    }

} 