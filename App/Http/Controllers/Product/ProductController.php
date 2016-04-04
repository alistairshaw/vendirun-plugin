<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use Redirect;
use Session;
use View;
use Request;

class ProductController extends VendirunBaseController {

    /**
     * @param string $category
     * @return \Illuminate\View\View
     */
    public function index($category = '')
    {
        $productSearchParams = $this->productSearchParams($category);
        $data = [];
        try
        {
            $data['products'] = VendirunApi::makeRequest('product/search', $productSearchParams)->getData();
            $data['productSearchParams'] = (array)$data['products']->search_params;

            //dd($data['products']);

            $data['pagination'] = ($data['products']) ? $data['pagination'] = new LengthAwarePaginator($data['products']->result, $data['products']->total_rows, $data['products']->limit, Request::get('page'), ['path' => '/product/']) : false;
        }
        catch (\Exception $e)
        {
            if (App::environment() == 'production') abort(404);
        }

        return View::make('vendirun::product.results', $data);
    }

    public function view($id, $productName)
    {

    }

    /**
     * Clear the search and redirect to index
     */
    public function clearSearch()
    {
        Session::forget('productSearchParams');

        return Redirect::route(LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productSearch');
    }

    /**
     * @param string $category
     * @return mixed
     */
    private function productSearchParams($category = '')
    {
        if (isset($_POST) && count($_POST) > 0)
        {
            $productSearchParams = Input::all();
            Session::put('productSearchParams', $productSearchParams);
        }
        else
        {
            $productSearchParams = Session::get('productSearchParams');
        }

        if ($category) $productSearchParams['category'] = $category;

        if (isset($_GET['page']))
        {
            $productSearchParams['offset'] = $_GET['page'] - 1;
        }

        if (Input::get('keywords'))
        {
            $productSearchParams['search_string'] = Input::get('keywords');
        }

        if (Input::get('sku'))
        {
            $productSearchParams['sku'] = Input::get('sku');
        }

        $defaultLimit = 12;
        $productSearchParams['limit'] = (Input::has('limit')) ? Input::get('limit') : $defaultLimit;

        $productSearchParams['order_by'] = Config::get('vendirun.productDefaultSortBy', 'price');
        $productSearchParams['order_direction'] = Config::get('vendirun.productDefaultSortOrder', 'ASC');

        if (Input::has('order_by'))
        {
            $searchArray = explode("_", Input::get('order_by'));
            $productSearchParams['order_by'] = $searchArray[0];
            $productSearchParams['order_direction'] = (count($searchArray) == 2) ? $searchArray[1] : 'ASC';
        }

        return $productSearchParams;
    }
}