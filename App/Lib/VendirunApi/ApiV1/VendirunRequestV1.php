<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Base\AbstractVendirunRequest;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Base\VendirunRequest;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\InvalidApiRequestException;
use Config;

class VendirunRequestV1 extends AbstractVendirunRequest implements VendirunRequest  {

    /**
     * @var object
     */
    protected $api;

    /**
     * @var object
     */
    protected $response;

    /**
     * @param string $request
     * @param array $parameters
     * @throws InvalidApiRequestException
     */
    public function __construct($request, $parameters = [])
    {
        $requestArray = explode('/', trim($request, '/'));
        switch ($requestArray[0])
        {
            case 'client':
                $this->api = new ClientApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            case 'cms':
                $this->api = new CmsApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            case 'customer':
                $this->api = new CustomerApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            case 'property':
                $this->api = new PropertyApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            case 'product':
                $this->api = new ProductApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            case 'blog':
                $this->api = new BlogApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            case 'cart':
                $this->api = new CartApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            case 'util':
                $this->api = new UtilApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            case 'order':
                $this->api = new OrderApi(Config::get('vendirun.apiKey'), Config::get('vendirun.clientId'), Config::get('vendirun.apiEndPoint'));
                break;
            default:
                throw new InvalidApiRequestException($request);
        }

        $method = $requestArray[1];

        if (!method_exists($this->api, $method)) throw new InvalidApiRequestException($request);

        $response = $this->api->{$method}($parameters);

        if (!$response) throw new InvalidApiRequestException($request);

        $this->response = new VendirunResponseV1($response);

        return $this;
    }
}