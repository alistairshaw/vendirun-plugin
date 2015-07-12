<?php namespace Ambitiousdigital\Vendirun\Controllers\Cms;

use Ambitiousdigital\Vendirun\Controllers\VendirunBaseController;
use Ambitiousdigital\Vendirun\Lib\CmsApi;
use Redirect;
use View;

class PageController extends VendirunBaseController {

    public function __construct()
    {
        parent::__construct();
        $this->cmsApi = new CmsApi(config('vendirun.apiKey'), config('vendirun.clientId'), config('vendirun.apiEndPoint'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page = $this->cmsApi->page('');
        if (!$page) abort('404');

        $data['page'] = $page;

        return View::make('vendirun::cms.page', $data);
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function page($slug)
    {
        $page = $this->cmsApi->page($slug);
        if (!$page) abort('404');

        $data['page'] = $page;

        return View::make('vendirun::cms.page', $data);
    }

}