<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

class BlogApi extends BaseApi {

    /**
     * @param array $params
     * @return array
     */
    public function post($params = [])
    {
        $url = 'blog/post';
        return $this->request($url, $params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function search($params = [])
    {
        $url = 'blog/search';
        return $this->request($url, $params);
    }

} 