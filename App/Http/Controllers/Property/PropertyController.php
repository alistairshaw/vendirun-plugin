<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Property;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Illuminate\Pagination\LengthAwarePaginator;
use Redirect;
use Response;
use Session;
use SimpleXMLElement;
use View;
use Request;

class PropertyController extends VendirunBaseController {

    protected $primaryPages = true;

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $searchParams = $this->searchParams();
        $data = [];
        try
        {
            $data['properties'] = VendirunApi::makeRequest('property/search', $searchParams)->getData();
            $data['searchParams'] = (array)$data['properties']->search_params;

            $data['pagination'] = ($data['properties']) ? $data['pagination'] = new LengthAwarePaginator($data['properties']->result, $data['properties']->total_rows, $data['properties']->limit, Request::get('page'), ['path' => '/property/']) : false;
        }
        catch (\Exception $e)
        {
            if (App::environment() == 'production') abort(404);
        }

        return View::make('vendirun::property.listings.' . Config::get('vendirun.propertyListingsView'), $data);
    }

    /**
     * @return mixed
     */
    public function xml()
    {
        $searchParams = $this->searchParams();
        try
        {
            $properties = VendirunApi::makeRequest('property/search', $searchParams)->getData();

            function array_to_xml($data, &$xml_data)
            {
                foreach ($data as $key => $value)
                {
                    if (is_object($value)) $value = (array)$value;

                    if (is_array($value))
                    {
                        if (is_numeric($key))
                        {
                            $key = 'item' . $key; //dealing with <0/>..<n/> issues
                        }
                        $subnode = $xml_data->addChild($key);
                        array_to_xml($value, $subnode);
                    }
                    else
                    {
                        $xml_data->addChild("$key", htmlspecialchars("$value"));
                    }
                }
            }

            // initializing or creating array
            $data = (array)$properties;

            // creating object of SimpleXMLElement
            $xml_data = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

            // function call to convert array to xml
            array_to_xml($data, $xml_data);

            return Response::make($xml_data->asXML(), '200')->header('Content-Type', 'text/xml');
        }
        catch (\Exception $e)
        {
            if (App::environment() == 'production') abort(404);
            dd($e);
        }
    }

    /**
     * Clear the search and redirect to index
     */
    public function clearSearch()
    {
        Session::forget('searchParams');

        return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.propertySearch');
    }

    /**
     * @param int    $id
     * @param string $propertyName
     * @return mixed
     */
    public function propertyView($id, $propertyName = '')
    {
        $data = [];
        try
        {
            $property = VendirunApi::makeRequest('property/property', ['id' => $id]);
            $data['property'] = $property->getData();
            $data['propertyName'] = $propertyName;
        }
        catch (FailResponseException $e)
        {
            if (App::environment() == 'production') abort(404);
        }

        return View::make('vendirun::property.view.' . Config::get('vendirun.propertyInfoView'), $data);
    }

    /**
     * @return mixed
     */
    private function searchParams()
    {
        if (isset($_POST) && count($_POST) > 0)
        {
            $searchParams = Request::all();
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

        if (Request::get('keywords'))
        {
            $searchParams['search_string'] = Request::get('keywords');
        }

        if (Request::get('reference'))
        {
            $searchParams['reference'] = Request::get('reference');
        }

        switch (Config::get('vendirun.propertyListingsView'))
        {
            case 'type2':
                $defaultLimit = 5;
                break;
            default:
                $defaultLimit = 12;
        }
        $searchParams['limit'] = (Request::has('limit')) ? Request::get('limit') : $defaultLimit;

        $searchParams['order_by'] = Config::get('vendirun.propertyDefaultSortBy', 'created');
        $searchParams['order_direction'] = Config::get('vendirun.propertyDefaultSortOrder', 'DESC');

        if (Request::has('order_by'))
        {
            $searchArray = explode("_", Request::get('order_by'));
            $searchParams['order_by'] = $searchArray[0];
            $searchParams['order_direction'] = (count($searchArray) == 2) ? $searchArray[1] : 'ASC';
        }

        return $searchParams;
    }

    /**
     * @return View
     */
    public function search()
    {
        return View::make('vendirun::property.simple-search');
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function recommend($id)
    {
        $data = [];
        try
        {
            $property = VendirunApi::makeRequest('property/property', ['id' => $id]);
            $data['property'] = $property->getData();
        }
        catch (FailResponseException $e)
        {
            if (App::environment() == 'production') abort(404);
        }

        return View::make('vendirun::property.recommend', $data);
    }
}