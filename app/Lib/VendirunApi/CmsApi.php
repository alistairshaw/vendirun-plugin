<?php namespace Ambitiousdigital\Vendirun\App\Lib\VendirunApi;

class CmsApi extends BaseApi {

    /**
     * @param $slug
     * @return array
     */
    public function page($slug)
    {
        $url = 'cms/page';
        $this->request($url, ['slug' => $slug]);
        $response = $this->getResult();

        return ($response['success']) ? $response['data'] : false;
    }

    public function menus()
    {
        $url = 'cms/menus';
        $this->request($url);
        $response = $this->getResult();

        return ($response['success']) ? $response['data'] : false;
    }

} 