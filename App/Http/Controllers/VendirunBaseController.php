<?php namespace AlistairShaw\Vendirun\App\Http\Controllers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\ClientApi;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\CustomerApi;
use App\Http\Controllers\Controller;
use Config;
use Session;
use Request;
use View;

class VendirunBaseController extends Controller {

	/**
	 * @var CustomerApi
	 */
	protected $customerApi;

	public function __construct()
	{
		Session::put('current_page_route', Request::path());

		$this->customerApi = new CustomerApi(config('vendirun.apiKey'), config('vendirun.clientId'), config('vendirun.apiEndPoint'));

        // set public client information to the config so we have access to it everywhere
		$clientApi = new ClientApi(config('vendirun.apiKey'), config('vendirun.clientId'), config('vendirun.apiEndPoint'));
        Config::set('clientInfo', $clientApi->publicInfo());

		// check if token exists and confirm login
		if (Session::has('token'))
		{
			$token = Session::get('token')->token;

			$loggedIn = $this->customerApi->tokenAuth($token);
			if ($loggedIn['success'])
			{
				View::share('loggedInName', $loggedIn['data']->name);
				View::share('loggedInEmail', $loggedIn['data']->email);
			}
			else
			{
				Session::remove('token');
			}
		}
	}

}