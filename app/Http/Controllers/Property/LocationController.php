<?php namespace Ambitiousdigital\Vendirun\App\Http\Controllers\Property;

use Ambitiousdigital\Vendirun\App\Http\Controllers\VendirunBaseController;
use Ambitiousdigital\Vendirun\App\Lib\VendirunApi\PropertyApi;
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
     * @param string $locationId
     * @return View
     */
	public function index($locationName = '', $locationId = '')
	{
		$searchParams['location_name'] = urldecode($locationName);
		$searchParams['location_id']   = urldecode($locationId);
		$response                      = $this->propertyApi->getLocation($searchParams);
		$data['locationData']          = ($response['success'] == 1) ? $response['data'] : array();

		$data['page'] = (object)[
			'title' => $locationName ? urldecode($locationName) : 'Property Categories',
            'meta_description' => $locationId ? $data['locationData']->master_location->location_description : '',
            'meta_keywords' => $locationId ? 'Property in ' . $data['locationData']->master_location->location_name : '',
		];

		if (count($data['locationData']->parent_location) > 0 || $locationName != '')
		{
			$locationName       = isset($data['locationData']->parent_location->location_name) ? $data['locationData']->parent_location->location_name : '';
			$locationId         = isset($data['locationData']->parent_location->id) ? $data['locationData']->parent_location->id : '';
			$data['backButton'] = [$locationName, $locationId];
		}

		return View::make('vendirun::property.locations', $data);
	}
}