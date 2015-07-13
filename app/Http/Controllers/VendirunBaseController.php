<?php namespace Ambitiousdigital\Vendirun\App\Http\Controllers;

use Ambitiousdigital\Vendirun\App\Lib\VendirunApi\CustomerApi;
use App\Http\Controllers\Controller;
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