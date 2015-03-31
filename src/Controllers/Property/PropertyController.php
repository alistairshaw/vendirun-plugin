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

class PropertyController extends VendirunBaseController
{

	private $propertyApi;

	public function __construct()
	{
		$this->propertyApi = new PropertyApi(config('vendirun.apiKey'), config('vendirun.clientId'), config('vendirun.apiEndPoint'));
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$data['searchParams'] = $this->searchParams();

		$data['favouriteProperties'] = $this->propertyApi->getFavourite(Session::get('token'), true);
		$data['categories'] = $this->propertyApi->getCategories();
		$data['properties'] = $this->propertyApi->search($data['searchParams']);
		$data['pagination'] = ($data['properties']) ? $data['pagination'] = new LengthAwarePaginator($data['properties']->result, $data['properties']->total_rows, $data['properties']->limit, Request::get('page'), ['path'=>'/property/']) : false;

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
	 * @param $id
	 * @return mixed
	 */
	public function propertyView($id)
	{
		$searchParams['id'] = $id;

		$data['property'] = $this->propertyApi->property($searchParams);
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

		if (!$token)
		{
			Session::put('action', '/property/add-to-favourite/' . $propertyId);
			return Redirect::route('vendirun.register');
		}

		$params['token']       = $token->token;
		$params['property_id'] = $propertyId;
		$this->propertyApi->addToFavourite($params);

		if (is_object($token) && count($token) > 0)
		{
			if (Session::get('current_page_route'))
			{
				return Redirect::to(Session::get('current_page_route'));
			}

			return Redirect::back();
		}
		else
		{
			Session::flash('alert_message_failure', 'Invalid token please login');

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
		if (!$token)
		{
			return Redirect::route('vendirun.register');
		}

		$params['token']       = $token->token;
		$params['property_id'] = $propertyId;
		$response              = $this->propertyApi->removeFavourite($params);


		if ($response['success'])
		{
			return Redirect::back();
		}
		else
		{
			Session::flash('alert_message_failure', 'Opps! Something Went wrong!');
			return Redirect::route('vendirun.register');
		}

	}

	/**
	 * Displays favourite properties
	 */
	public function viewFavouriteProperties()
	{
		$token = Session::get('token');
		if (!$token)
		{
			Session::flash('alert_message_failure', 'Invalid token please login');

			return Redirect::route('vendirun.register');
		}

		$data['bodyClass'] = 'property-search';

		$data['favouriteProperties'] = $this->propertyApi->getFavourite(Session::get('token'));

		if (count($data['favouriteProperties']) > 0)
		{
			$searchParams['favourite_only'] = implode(',', $data['favouriteProperties']);
			$response                       = $this->propertyApi->search($searchParams);

			$data['property'] = ($response['success'] == 1) ? $response['data'] : array();

		}

		return View::make('vendirun::property.favourite_properties', $data);
	}

	/**
	 * Locations from the cms
	 */
	public function location()
	{

	}

}