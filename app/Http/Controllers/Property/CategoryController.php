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
	 * @param string $categoryName
	 * @return View
	 */
	public function index($categoryName = '')
	{
		$data['categoryName'] = $categoryName;
		$category = $this->propertyApi->getLocation($categoryName);

		$data['page'] = (object)[
			'title' => $categoryName ? urldecode($categoryName) : 'Property Categories',
			'meta_description' => isset($category->id) ? $category->category_description : '',
			'meta_keywords' => isset($category->id) ? 'Property in ' . $category->category_name : '',
		];

		return View::make('vendirun::property.category', $data);
	}
}