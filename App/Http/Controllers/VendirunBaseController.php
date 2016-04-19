<?php namespace AlistairShaw\Vendirun\App\Http\Controllers;

use AlistairShaw\Vendirun\App\Lib\ClientHelper;
use App;
use App\Http\Controllers\Controller;
use Config;
use Session;
use Request;

class VendirunBaseController extends Controller {

    /**
     * @var object VendirunApi
     */
    protected $vendirunApi;

    /**
     * Use this flag on controllers that contain primary pages that we can redirect to.
     *   We redirect back to here from more complex step-by-step procedures, for example
     *   when cancelling the shopping cart or going through a login/registration procedure for
     *   adding to wishlist / favourites / cart / etc
     *
     * You can also set it from inside any specific function
     * @var bool
     */
    protected $primaryPages = false;

    public function __construct()
    {
        if ($this->primaryPages) $this->setPrimaryPath();

        // set public client information to the config so we have access to it everywhere
        $clientInfo = ClientHelper::getClientInfo();

        Config::set('clientInfo', $clientInfo);
    }

    /**
     * Call this from a controller to make just one function a primary path if necessary
     */
    protected function setPrimaryPath()
    {
        $path = Request::getPathInfo() . (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');

        Session::put('primaryPagePath', $path);
    }

}