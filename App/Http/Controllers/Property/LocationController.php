<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Property;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\PropertyApi;
use View;

class LocationController extends VendirunBaseController {

	/**
	 * @var PropertyApi
	 */
	private $propertyApi;

	public function __construct()
	{
		parent::__construct();
		$this->propertyApi = new PropertyApi(config('vendirun.apiKey'), config('vendirun.clientId'), config('vendirun.apiEndPoint'));
	}

    /**
     * @param string $locationName
     * @return View
     */
	public function index($locationName = '')
	{
		$data['locationName'] = $locationName;
        $location = $this->propertyApi->getLocation($locationName);

		$data['page'] = (object)[
			'title' => $locationName ? urldecode($locationName) : 'Property Categories',
            'meta_description' => isset($location->id) ? $location->location_description : '',
            'meta_keywords' => isset($location->id) ? 'Property in ' . $location->location_name : '',
		];

		return View::make('vendirun::property.locations', $data);
	}
}