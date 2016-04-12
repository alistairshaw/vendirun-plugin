<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Illuminate\View\View;
use URL;

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

    /**
     * @param View        $view
     */
    public function socialShare($view)
    {
        $viewData = $view->getData();

        $socialLinks = App::make('AlistairShaw\Vendirun\App\Lib\Social\SocialLinks');

        // get page title, description and image
        switch (true)
        {
            case (isset($viewData['product'])):
                $pageTitle = $viewData['product']->product_name;
                $pageText = $viewData['product']->short_description;
                $pageImage = $viewData['product']->images{0}->mediumsq;
                break;
            default:
                $pageTitle = '';
                $pageText = '';
                $pageImage = '';
        }

        $social = $socialLinks->getLinks(URL::full(), $pageTitle, $pageText, $pageImage);
        $view->with('socialLinks', $social);
    }

    /**
     * @param $view
     */
    public function regions($view)
    {
        $regions = VendirunApi::makeRequest('util/countries')->getData();
        $view->with('regions', $regions);
    }

    /**
     * @param $view
     */
    public function titles($view)
    {
        $titles = VendirunApi::makeRequest('util/titles')->getData();
        $view->with('titles', $titles);
    }
}