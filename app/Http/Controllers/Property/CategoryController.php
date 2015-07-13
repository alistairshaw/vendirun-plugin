<?php namespace Ambitiousdigital\Vendirun\App\Http\Controllers\Property;

use Ambitiousdigital\Vendirun\App\Http\Controllers\VendirunBaseController;
use Ambitiousdigital\Vendirun\App\Lib\VendirunApi\PropertyApi;
use View;

class CategoryController extends VendirunBaseController {

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
	public function index()
    {
        $data['page'] = (object)[
            'title' => 'Property Categories'
        ];

		return View::make('vendirun::property.categories', $data);
	}
}