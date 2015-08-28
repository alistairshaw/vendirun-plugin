<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi;

class ClientApi extends BaseApi {

    public function publicInfo()
    {
        $url = 'client';
        $this->request($url, [], false, 60);
        $response = $this->getResult();

        return ($response['success']) ? $response['data'] : false;
    }

}