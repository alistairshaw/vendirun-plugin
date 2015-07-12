<?php namespace Ambitiousdigital\Vendirun\Controllers\Property;

use Ambitiousdigital\Vendirun\Controllers\VendirunBaseController;
use Ambitiousdigital\Vendirun\Lib\PropertyApi;
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

		$data['categories'] = $this->propertyApi->getCategories();

		return View::make('vendirun::property.categories', $data);
	}
}