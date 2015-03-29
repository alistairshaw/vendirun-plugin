<?php

namespace Ambitiousdigital\Vendirun\Controllers\Property;

use Ambitiousdigital\Vendirun\Lib\IdObfuscator;
use Ambitiousdigital\Vendirun\Lib\PropertyApi;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PropertyController extends Controller
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
		$data['bodyClass']    = 'property-search';
		$data['searchParams'] = $this->searchParams();

		$data['favouriteProperties'] = $this->getFavouriteProperties();

		$response = $this->propertyApi->search($data['searchParams']);
		$data['properties'] = ($response['success'] == 1) ? $response['data'] : array();

		$response   = $this->propertyApi->getCategories();
		$categories = ($response['success'] == 1) ? $response['data'] : array();

		$data['categories'] = $this->getCategories($categories);
		$data['paginator']  = new LengthAwarePaginator($data['properties']->result, $data['properties']->total_rows, $data['properties']->limit);

		// Setting up current Page.
		Session::put('current_page_route', '/property-search');

		return View::make('vendirun::property.search', $data);
	}

	private function getFavouriteProperties()
	{
		$token = Session::get('token');
		if (!$token) return array();

		$response = $this->propertyApi->getFavourite($token);

		$favProperties = ($response['success'] == 1) ? $response['data'] : array();

		$favPropertiesIds = array();

		if ($favProperties && count($favProperties) > 0)
		{
			foreach ($favProperties as $row)
			{
				$favPropertiesIds[] = $row->property_id;
			}
		}

		return $favPropertiesIds;
	}

	/**
	 * @param $id
	 * @param $propertyName
	 * @return mixed
	 */
	public function propertyView($id, $propertyName)
	{
		$idObfuscator       = new IdObfuscator();
		$searchParams['id'] = $idObfuscator->decode($id);

		$response         = $this->propertyApi->property($searchParams);
		$data['property'] = ($response['success'] == 1) ? $response['data'] : array();

		$data['favouriteProperties'] = $this->getFavouriteProperties();

		$data['bodyClass'] = 'property-view';

		// Setting up current Page.
		Session::put('current_page_route', '/property-view/' . $id . '/' . $propertyName);

		return View::make('vendirun::property.view', $data);
	}

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

	public function getCategories($categories, $parent_name = '')
	{
		$finaArray = array();

		if ($categories && count($categories) > 0)
		{
			foreach ($categories as $row)
			{
				$tempArray['category_name'] = ($parent_name != '') ? $parent_name . ' > ' . $row->category_name : $row->category_name;
				$tempArray['id']            = $row->id;
				$finaArray[]                = $tempArray;
				if (count($row->sub_categories) > 0)
				{
					$childArray = $this->getCategories($row->sub_categories, $tempArray['category_name']);
					$finaArray  = array_merge($finaArray, $childArray);
				}

			}
		}
		return $finaArray;
	}

	/**
	 * Add Property to Favourite
	 * @param $propertyId
	 * @return
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
		$success               = $this->propertyApi->addToFavourite($params);

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

		$data['favouriteProperties'] = $this->getFavouriteProperties();


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