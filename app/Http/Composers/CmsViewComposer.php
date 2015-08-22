<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\CmsApi;
use Request;
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
     * Composer for the menu item, Checks if the menu is already set, if not does the API request
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

    /**
     * Figures out if the menu item we're displaying should be active
     * @param $view
     */
    public function menuLink($view)
    {
        $viewData = $view->getData();
        $activeClass = '';
        $item = $viewData['item'];
        // it's active if it's an exact match to the slug
        if ('/' . Request::path() == $item->slug)
        {
            $activeClass = 'active';
        }
        // it's also active if it's the first part of the slug
        else if (strpos('/' . Request::path(), $item->slug) === 0)
        {
            // unless the slug is the homepage
            if ($item->slug !== '/') $activeClass = 'active';
        }

        $view->with('activeClass', $activeClass);
    }
}