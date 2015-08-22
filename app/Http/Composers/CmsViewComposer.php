<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\CmsApi;
use View;

class CmsViewComposer {

    private $cmsApi;

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
     * Composer for navigation, fetches the menu from the API
     * @param View $view
     */
    public function menu($view)
    {
        $viewData = $view->getData();
        $slug = isset($viewData['menuSlug']) ? $viewData['menuSlug'] : '';

        $menu = $this->cmsApi->menu($slug);

        $view->with('menu', $menu);
    }

    /**
     * Composer for the menu item, checks if the menu is already set, if not does the
     *    API request
     * @param $view
     */
    public function menuItem($view)
    {
        $viewData = $view->getData();
        if (!isset($viewData['menu']))
        {
            $slug = isset($viewData['menuSlug']) ? $viewData['menuSlug'] : '';

            $menu = $this->cmsApi->menu($slug);

            $view->with('menu', $menu->sub_menu);
        }
    }
}