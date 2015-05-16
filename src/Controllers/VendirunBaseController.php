<?php namespace Ambitiousdigital\Vendirun\Controllers;

use Ambitiousdigital\Vendirun\Lib\CustomerApi;
use App\Http\Controllers\Controller;
use Session;
use Request;

class VendirunBaseController extends Controller {

	/**
	 * @var array
	 */
	var $viewData;

	public function __construct()
	{
		Session::put('current_page_route', Request::path());

		// check if token exists and confirm login
		if (Session::has('token'))
		{
			$customerApi = new CustomerApi();
			$loggedIn = $customerApi->tokenAuth(Session::get('token'));
			if ($loggedIn)
			{
				$this->viewData['loggedInName'] = $loggedIn['name'];
				$this->viewData['loggedInEmail'] = $loggedIn['email'];
			}
			else
			{
				Session::remove('token');
			}
		}
	}

}