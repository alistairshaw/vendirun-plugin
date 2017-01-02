<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

class CmsApi extends BaseApi {

    /**
     * @return object
     */
    public function css()
    {
        $url = 'cms/css';
        return $this->request($url);
    }

    /**
     * @param array $params
     * @return object
     */
    public function page($params)
    {
        $url = 'cms/page';
        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return object
     */
    public function menu($params)
    {
        $url = 'cms/menu';
        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     */
    public function slider($params)
    {
        $url = 'cms/slider/' . $params['id'];
        return $this->request($url);
    }

} 