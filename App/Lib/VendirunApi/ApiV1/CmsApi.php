<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

class CmsApi extends BaseApi {

    /**
     * @param array $params
     * @return array
     */
    public function page($params)
    {
        $url = 'cms/page';
        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function menu($params)
    {
        $url = 'cms/menu';
        return $this->request($url, $params);
    }

} 