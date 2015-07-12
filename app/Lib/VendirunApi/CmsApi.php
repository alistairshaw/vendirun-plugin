<?php namespace Ambitiousdigital\Vendirun\App\Lib\VendirunApi;

class CmsApi extends BaseApi {

    /**
     * @param $slug
     * @return array
     */
    function page($slug)
    {
        $url = 'cms/page';
        $this->request($url, ['slug' => $slug]);
        $response = $this->getResult();

        return ($response['success']) ? $response['data'] : false;
    }

} 