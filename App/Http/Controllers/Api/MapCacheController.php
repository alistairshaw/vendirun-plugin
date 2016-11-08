<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use Cache;
use Request;
use Response;

/**
 * Note: This one is not yet part of the main API
 * Class MapCacheController
 * @package AlistairShaw\Vendirun\App\Http\Controllers\Api
 */
class MapCacheController extends VendirunBaseController {

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


}