<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Illuminate\View\View;
use Request;
use URL;

class WidgetViewComposer {

    /**
     * Social media buttons
     * @param View $view
     */
    public function social($view)
    {
        $clientInfo = Config::get('clientInfo');
        $view->with('social', $clientInfo->social)->with('socialType', Config::get('socialType', 'light'));
    }

}