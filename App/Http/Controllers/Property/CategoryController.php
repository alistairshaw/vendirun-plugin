<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Property;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\PropertyApi;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use View;

class CategoryController extends VendirunBaseController {

    protected $primaryPages = true;

	/**
	 * @param string $categoryName
	 * @return View
	 */
	public function index($categoryName = '')
	{
		return View::make('vendirun::property.category', ['categoryName' => $categoryName]);
	}
}