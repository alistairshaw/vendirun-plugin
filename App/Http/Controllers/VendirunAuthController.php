<?php namespace AlistairShaw\Vendirun\App\Http\Controllers;

use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use App;
use Redirect;
use Request;
use Session;

class VendirunAuthController extends VendirunBaseController {

    public function __construct()
    {
        parent::__construct();

        if (!CustomerHelper::checkLoggedinCustomer())
        {
            $path = Request::getPathInfo() . (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');
            Session::put('attemptedAction', $path);
            Session::save();

            Redirect::route(LocaleHelper::localePrefix() . 'vendirun.register')->send();
        }
    }

}