<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

class ClientApi extends BaseApi {

    /**
     * @return array
     */
    public function publicInfo()
    {
        $url = 'client';
        return $this->request($url, [], false, 60);
    }

}