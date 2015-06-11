<?php

namespace Ambitiousdigital\Vendirun\Controllers\Property;

use Ambitiousdigital\Vendirun\Controllers\VendirunBaseController;
use Ambitiousdigital\Vendirun\Lib\PropertyApi;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use Redirect;
use Session;
use View;
use Request;

class PropertyController extends VendirunBaseController {

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
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$data['searchParams'] = $this->searchParams();

        $data['favouriteProperties'] = $this->propertyApi->getFavourite(Session::get('token'), true);
        $data['categories']          = $this->propertyApi->getCategories();
        $data['properties']          = $this->propertyApi->search($data['searchParams']);


		$data['searchParams'] = (array)$data['properties']->search_params;

		$data['pagination'] = ($data['properties']) ? $data['pagination'] = new LengthAwarePaginator($data['properties']->result, $data['properties']->total_rows, $data['properties']->limit, Request::get('page'), ['path' => '/property/']) : false;

		return View::make('vendirun::property.search', $data);
	}

	/**
	 * Clear the search and redirect to index
	 */
	public function clearSearch()
	{
		Session::forget('searchParams');

		return Redirect::route('vendirun.propertySearch');
	}

	/**
	 * @param int    $id
	 * @param string $propertyName
	 * @return mixed
	 */
	public function propertyView($id, $propertyName = '')
	{
		$searchParams['id'] = $id;

		$data['property']            = $this->propertyApi->property($searchParams);
		$data['favouriteProperties'] = $this->propertyApi->getFavourite(Session::get('token'), true);

		return View::make('vendirun::property.view', $data);
	}

	/**
	 * @return mixed
	 */
	private function searchParams()
	{
		if (isset($_POST) && count($_POST) > 0)
		{
			$searchParams = Input::all();
			Session::put('searchParams', $searchParams);
		}
		else
		{
			$searchParams = Session::get('searchParams');
		}

		if (isset($_GET['page']))
		{
			$searchParams['offset'] = $_GET['page'] - 1;
		}

		if (Input::get('keywords'))
		{
			$searchParams['search_string'] = ' ' . Input::get('keywords');
			$searchParams['search_string'] = Input::get('keywords');
		}

		$searchParams['limit'] = (Input::get('limit')) ? Input::get('limit') : 5;

		return $searchParams;
	}

	/**
	 * Add Property to Favourite
	 * @param $propertyId
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function addToFavourite($propertyId)
	{
		$token = Session::get('token');

		if ( ! $token)
		{
			Session::put('action', '/property/add-to-favourite/' . $propertyId);

			return Redirect::route('vendirun.register');
		}

		$params['token']       = $token->token;
		$params['property_id'] = $propertyId;
		$response              = $this->propertyApi->addToFavourite($params);

		if ($response['success'])
		{
			return Redirect::route('vendirun.propertyView', ['id' => $propertyId]);
		}
		else
		{
			Session::flash('vendirun-alert-error', 'Oops! Something Went wrong! Please try again.');

			return Redirect::route('vendirun.register');
		}
	}

	/**
	 * @param $propertyId
	 * @return mixed
	 */
	public function removeFavourite($propertyId)
	{
		$token = Session::get('token');
		if ( ! $token)
		{
			return Redirect::route('vendirun.register');
		}

		$params['token']       = $token->token;
		$params['property_id'] = $propertyId;
		$response              = $this->propertyApi->removeFavourite($params);

		if ($response['success'])
		{
			return Redirect::route('vendirun.propertyView', ['id' => $propertyId]);
		}
		else
		{
			Session::flash('vendirun-alert-error', 'Oops! Something Went wrong! Please try again.');

			return Redirect::route('vendirun.register');
		}

	}

	/**
	 * Displays favourite properties
	 */
	public function viewFavouriteProperties()
	{
		$token = Session::get('token');
		if ( ! $token)
		{
			Session::flash('vendirun-alert-error', 'Invalid token please login');

			return Redirect::route('vendirun.register');
		}

		$data['bodyClass'] = 'property-search';
		$data['property']  = $this->propertyApi->getFavourite(Session::get('token'));

		return View::make('vendirun::property.favourite_properties', $data);
	}

	/**
	 * @return View
	 */
	public function search()
	{
		return View::make('vendirun::property.simple-search');
	}
}