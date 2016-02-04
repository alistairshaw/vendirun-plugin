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
            Session::put('action', Request::url());

            Redirect::route(LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.register')->send();
        }
    }

}