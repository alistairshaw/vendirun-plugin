<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Cms;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\CmsApi;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Cache;
use Request;
use Response;
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

    public function mapCacheRetrieve()
    {
        $address = sha1(Request::input('address'));
        if (!Request::input('address')) return Response::json(['success' => false]);

        //dd($address);

        $lat = Cache::get('mapCacheLat' . $address, false);
        $lng = Cache::get('mapCacheLng' . $address, false);

        if (!$lat || !$lng) return Response::json(['success' => false]);

        return Response::json(['success' => true, 'lat' => $lat, 'lng' => $lng]);
    }

    public function mapCacheSet()
    {
        $address = sha1(Request::input('address'));
        $lat = Request::input('lat');
        $lng = Request::input('lng');

        // dd($lat, $lng, $address);

        if ($lat && $lng)
        {
            Cache::forever('mapCacheLat' . $address, $lat);
            Cache::forever('mapCacheLng' . $address, $lng);
        }
    }
}