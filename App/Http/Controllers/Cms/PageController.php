<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Cms;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\CmsApi;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use View;

class PageController extends VendirunBaseController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->page('');
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function page($slug)
    {
        try
        {
            $page = VendirunApi::makeRequest('cms/page', ['slug' => $slug]);
            $data['page'] = $page->getData();
            return View::make('vendirun::cms.page', $data);
        }
        catch (FailResponseException $e)
        {
            abort('404');
        }
    }

    /**
     * Example of a menu from the API
     * @return \Illuminate\View\View
     */
    public function menu()
    {
        return View::make('vendirun::cms.menu', ['menuSlug' => 'main-menu']);
    }
}