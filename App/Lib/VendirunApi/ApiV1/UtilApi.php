<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

class UtilApi extends BaseApi {

    /**
     * @param array $params
     * @return array
     */
    public function countries($params)
    {
        $url = 'util/countries';

        return $this->request($url, $params);
    }
}