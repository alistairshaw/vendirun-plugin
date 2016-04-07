<?php namespace AlistairShaw\Vendirun\App\Http\Controllers;

use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use App;
use Redirect;
use Request;
use Session;

class VendirunAuthController extends VendirunBaseController {

    public function __construct()
    {
        parent::__construct();

        if (!Session::has('token'))
        {
            $path = Request::getPathInfo() . (Request::getQueryString() ? ('?' . Request::getQueryString()) : '');
            Session::put('attemptedAction', $path);
            Session::save();

            Redirect::route(LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.register')->send();
        }
    }

}