<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Property;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use View;

class LocationController extends VendirunBaseController {

    protected $primaryPages = true;

    /**
     * @param string $locationName
     * @return View
     */
	public function index($locationName = '')
	{
		return View::make('vendirun::property.location')->with('locationName', $locationName);
	}
}