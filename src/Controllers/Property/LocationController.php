<?php namespace Ambitiousdigital\Vendirun\Controllers\Property;

use Ambitiousdigital\Vendirun\Controllers\VendirunBaseController;
use Ambitiousdigital\Vendirun\Lib\PropertyApi;
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
	 * @return View
	 */
	public function index($locationName = '', $locationId = '')
	{
		$searchParams['location_name'] = urldecode($locationName);
		$searchParams['location_id']   = urldecode($locationId);
		$response                      = $this->propertyApi->getLocation($searchParams);
		$data['locationData']          = ($response['success'] == 1) ? $response['data'] : array();

		if (count($data['locationData']->parent_location) > 0 || $locationName != '')
		{
			$locationName       = isset($data['locationData']->parent_location->location_name) ? $data['locationData']->parent_location->location_name : '';
			$locationId         = isset($data['locationData']->parent_location->id) ? $data['locationData']->parent_location->id : '';
			$data['backButton'] = [$locationName, $locationId];
		}

		return View::make('vendirun::property.locations', $data);
	}
}