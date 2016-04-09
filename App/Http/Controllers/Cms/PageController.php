<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Cms;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Cache;
use Request;
use Response;
use View;

class PageController extends VendirunBaseController {

    protected $primaryPages = true;
    
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
    public function page($slug = '')
    {
        $data = [];
        try
        {
            $page = VendirunApi::makeRequest('cms/page', ['slug' => $slug, 'locale' => App::getLocale()]);
            $data['page'] = $page->getData();
        }
        catch (FailResponseException $e)
        {
            abort('404');
        }

        return View::make('vendirun::cms.page', $data);
    }

    /**
     * Example of a menu from the API
     * @return \Illuminate\View\View
     */
    public function menu()
    {
        return View::make('vendirun::cms.menu', ['menuSlug' => 'main-menu']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function mapCacheRetrieve()
    {
        $address = sha1(Request::input('address'));
        if (!Request::input('address')) return Response::json(['success' => false]);

        $lat = Cache::get('mapCacheLat' . $address, false);
        $lng = Cache::get('mapCacheLng' . $address, false);

        if (!$lat || !$lng) return Response::json(['success' => false]);

        return Response::json(['success' => true, 'lat' => $lat, 'lng' => $lng]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function mapCacheSet()
    {
        $address = sha1(Request::input('address'));
        $lat = Request::input('lat');
        $lng = Request::input('lng');

        if ($lat && $lng)
        {
            Cache::forever('mapCacheLat' . $address, $lat);
            Cache::forever('mapCacheLng' . $address, $lng);
        }

        return Response::json(['success' => true]);
    }

    /**
     * @param $staffId
     * @return \Illuminate\View\View
     */
    public function staff($staffId)
    {
        $staff = VendirunApi::makeRequest('client/staff', ['id' => $staffId])->getData();
        if (!$staff) abort(404);

        return View::make('vendirun::cms.staff', ['person' => $staff]);
    }
}