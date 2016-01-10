<?php namespace AlistairShaw\Vendirun\App\Http\Controllers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use App\Http\Controllers\Controller;
use Config;
use Session;
use Request;
use View;

class VendirunBaseController extends Controller {

	/**
	 * @var object VendirunApi
	 */
	protected $vendirunApi;

	public function __construct()
	{
		Session::put('current_page_route', Request::path());

        // set public client information to the config so we have access to it everywhere
		$clientInfo = VendirunApi::makeRequest('client/publicInfo')->getData();
        Config::set('clientInfo', $clientInfo);
	}

}