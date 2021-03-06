<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Property;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunAuthController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Redirect;
use Session;
use View;

class PropertyAuthController extends VendirunAuthController {

    /**
     * Add Property to Favourite
     * @param $propertyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToFavourite($propertyId)
    {
        $response = VendirunApi::makeRequest('property/addToFavourite', ['token' => Session::get('token'), 'property_id' => $propertyId]);

        if (!$response->getSuccess()) Session::flash('vendirun-alert-error', $response->getError());

        return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.propertyView', ['id' => $propertyId]);
    }

    /**
     * @param $propertyId
     * @return mixed
     */
    public function removeFavourite($propertyId)
    {
        $response = VendirunApi::makeRequest('property/removeFavourite', ['token' => Session::get('token'), 'property_id' => $propertyId]);

        if (!$response->getSuccess()) Session::flash('vendirun-alert-error', $response->getError());

        return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.propertyView', ['id' => $propertyId]);
    }

    /**
     * Displays favourite properties
     */
    public function viewFavouriteProperties()
    {
        $properties = VendirunApi::makeRequest('property/getFavourite', ['token' => Session::get('token'), 'idsOnly' => false]);
        return View::make('vendirun::property.favourite-properties')->with('properties', $properties->getData());
    }

}