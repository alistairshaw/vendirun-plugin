<?php namespace Ambitiousdigital\Vendirun\App\Http\Composers;

use Ambitiousdigital\Vendirun\App\Lib\VendirunApi\CmsApi;
use View;

class CmsViewComposer {

    public function __construct()
    {
        $this->cmsApi = new cmsApi();
    }

    /**
     * Composer for main CMS page
     * @param $view
     */
    public function compose($view)
    {

    }

    /**
     * Composer for navigation, fetches all available menus from API and stores
     *   in array with the menu slug as the key
     * @param View $view
     */
    public function menu($view)
    {

    }

}