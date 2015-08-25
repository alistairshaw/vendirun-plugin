<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Property;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\PropertyApi;
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
        $data['page'] = (object)[
            'title' => 'Property Search',
        ];

        $data['searchParams'] = $this->searchParams();

        $data['favouriteProperties'] = $this->propertyApi->getFavourite(Session::get('token'), true);
        $categories = $this->propertyApi->getCategoryList();
        $data['categories'] = $categories['data'];
        $data['properties'] = $this->propertyApi->search($data['searchParams']);

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

        $property = $this->propertyApi->property($searchParams);
        if (!$property) abort(404);

        $data['property'] = $property;
        $data['favouriteProperties'] = $this->propertyApi->getFavourite(Session::get('token'), true);

        $data['page'] = (object)[
            'title' => $property->title,
            'meta_description' => strip_tags($property->short_description),
            'meta_keywords' => $property->keywords
        ];

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

        if (isset($_GET['propertytype']))
        {
            $searchParams['propertytype'] = $_GET['propertytype'];
        }

        if (isset($_GET['location']))
        {
            $searchParams['location'] = $_GET['location'];
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

        $params['token'] = $token->token;
        $params['property_id'] = $propertyId;
        $response = $this->propertyApi->addToFavourite($params);

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
        if (!$token)
        {
            return Redirect::route('vendirun.register');
        }

        $params['token'] = $token->token;
        $params['property_id'] = $propertyId;
        $response = $this->propertyApi->removeFavourite($params);

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
        $data['page'] = (object)[
            'title' => 'Favourite Properties'
        ];

        $token = Session::get('token');
        if (!$token)
        {
            Session::flash('vendirun-alert-error', 'Invalid token please login');

            return Redirect::route('vendirun.register');
        }

        $data['bodyClass'] = 'property-search';
        $data['property'] = $this->propertyApi->getFavourite(Session::get('token'));

        return View::make('vendirun::property.favourite_properties', $data);
    }

    /**
     * @return View
     */
    public function search()
    {
        $data['page'] = (object)[
            'title' => 'Smart Search'
        ];

        return View::make('vendirun::property.simple-search');
    }
}