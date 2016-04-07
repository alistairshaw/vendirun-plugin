<?php namespace AlistairShaw\Vendirun\App\Http\Controllers;

use AlistairShaw\Vendirun\App\Lib\ClientHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use App\Http\Controllers\Controller;
use Config;
use Redirect;
use Session;
use Request;
use View;

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
        $path = Request::getPathInfo() . (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');
        if ($this->primaryPages)
        {
            Session::put('primaryPagePath', $path);
            Session::save();
        }

        // set public client information to the config so we have access to it everywhere
		$clientInfo = ClientHelper::getClientInfo();
        Config::set('clientInfo', $clientInfo);
	}

}