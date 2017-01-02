<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\ClientHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Illuminate\View\View;
use Request;
use URL;

class CmsViewComposer {

    /**
     * @param View $view
     */
    public function css($view)
    {
        $clientData = ClientHelper::getClientInfo();

        $customCSS = (isset($clientData->custom_css) && $clientData->custom_css) ? $clientData->custom_css : false;
        $view->with('customCSS', $customCSS);
    }

    /**
     * Composer for navigation, fetches the menu from the API
     * @param View $view
     */
    public function menu($view)
    {
        $viewData = $view->getData();
        $slug = isset($viewData['menuSlug']) ? $viewData['menuSlug'] : '';

        $menu = VendirunApi::makeRequest('cms/menu', ['slug' => $slug])->getData();

        $view->with('menu', $menu);
    }

    /**
     * Composer for the menu item, Checks if the menu is already set, if not does the API request
     * @param View $view
     */
    public function menuItem($view)
    {
        $viewData = $view->getData();
        if (!isset($viewData['menu']))
        {
            $slug = isset($viewData['menuSlug']) ? $viewData['menuSlug'] : '';

            $menu = VendirunApi::makeRequest('cms/menu', ['slug' => $slug])->getData();

            $view->with('menu', $menu->sub_menu);
        }
    }

    /**
     * Figures out if the menu item we're displaying should be active
     * @param View $view
     */
    public function menuLink($view)
    {
        $viewData = $view->getData();
        $activeClass = '';
        $item = $viewData['item'];

        $slug = $item->slug !== '' ? $item->slug : $item->url;
        if ($slug == '') $slug = '/foo';

        // it's active if it's an exact match to the slug
        if ('/' . Request::path() == $slug)
        {
            $activeClass = 'active';
        }
        // it's also active if it's the first part of the slug
        else if (strpos('/' . Request::path(), $slug) === 0)
        {
            // unless the slug is the homepage
            if ($slug !== '/') $activeClass = 'active';
            if ($slug == '/' && Request::path() == '/') $activeClass = 'active';
        }

        $clientInfo = Config::get('clientInfo');
        $locale = (isset($clientInfo->primary_language->language_code) && App::getLocale() == $clientInfo->primary_language->language_code) ? '' : '/' . App::getLocale();
        $link = ($item->slug) ? URL::to($locale . $item->slug) : $locale . $item->url;

        // translations, if any
        $translations = json_decode($item->translations, true);
        if (isset($translations[App::getLocale()]) && $translations[App::getLocale()] !== '') $item->page_name = $translations[App::getLocale()];

        $view->with('activeClass', $activeClass)->with('link', $link)->with('item', $item);
    }

    /**
     * @param View $view
     */
    public function head($view)
    {
        $view->with('clientData', Config::get('clientInfo'));
    }

    /**
     * @param View $view
     */
    public function footer($view)
    {
        $view->with('clientData', Config::get('clientInfo'));
    }

    /**
     * @param View $view
     */
    public function social($view)
    {
        $view->with('clientData', Config::get('clientInfo'));
    }

    /**
     * @param View $view
     */
    public function languages($view)
    {
        $clientInfo = Config::get('clientInfo');

        $languages = [];

        if (count($clientInfo->additional_languages) > 0)
        {
            $languages[] = [
                'language_code' => $clientInfo->primary_language->language_code,
                'language' => $clientInfo->primary_language->language,
                'country_code' => strtolower($clientInfo->primary_language->country_code)
            ];

            foreach ($clientInfo->additional_languages as $language)
            {
                $languages[] = [
                    'language_code' => $language->language_code,
                    'language' => $language->language,
                    'country_code' => strtolower($language->country_code)
                ];
            }
        }

        $view->with('languages', $languages)->with('clientInfo', $clientInfo);
    }

}