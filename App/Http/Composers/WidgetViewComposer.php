<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Illuminate\View\View;

class WidgetViewComposer {

    /**
     * Social media buttons
     * @param View $view
     */
    public function social($view)
    {
        if ($clientInfo = Config::get('clientInfo'))
        {
            $view->with('social', $clientInfo->social);
        }
        $view->with('socialType', Config::get('socialType', 'light'));
    }

    public function staff($view)
    {
        $staff = VendirunApi::makeRequest('client/staff')->getData();
        $view->with('staff', $staff);
    }

}