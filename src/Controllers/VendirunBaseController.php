<?php namespace Ambitiousdigital\Vendirun\Controllers;

use App\Http\Controllers\Controller;
use Session;
use Request;

class VendirunBaseController extends Controller {

	public function __construct()
	{
		Session::put('current_page_route', Request::path());
	}

}