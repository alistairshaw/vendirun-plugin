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

    protected $primaryPages = true;

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
            $data['category'] = $category;
            $data['selectedColor'] = Input::get('color', '');
            $data['selectedSize'] = Input::get('size', '');
            $data['selectedType'] = Input::get('type', '');
            $data['products'] = VendirunApi::makeRequest('product/search', $productSearchParams)->getData();

            $data['productSearchParams'] = (array)$data['products']->search_params;

            $data['pagination'] = ($data['products']) ? $data['pagination'] =
                new LengthAwarePaginator(
                    $data['products']->result,
                    $data['products']->total_rows,
                    $data['products']->limit,
                    Request::get('page'),
                    [
                        'path'  => Request::url(),
                        'query' => Request::query()
                    ]
                ) : false;
        }
        catch (\Exception $e)
        {
            if (App::environment() == 'production') abort(404);
        }

        return View::make('vendirun::product.results', $data);
    }

    /**
     * @param        $id
     * @param string $productName
     * @param int $productVariationId
     * @return \Illuminate\View\View
     */
    public function view($id, $productName = '', $productVariationId = null)
    {
        $searchParams = $this->productSearchParams();
        $searchParams['id'] = $id;
        $searchParams['product_variation_id'] = $productVariationId;
        $data['product'] = VendirunApi::makeRequest('product/product', $searchParams)->getData();

        $data['selectedVariation'] = $data['product']->variations{0};
        if ($productVariationId)
        {
            foreach ($data['product']->variations as $var)
            {
                if ($var->id == $productVariationId) $data['selectedVariation'] = $var;
            }
        }

        return View::make('vendirun::product.view', $data);
    }

    /**
     * Clear the search and redirect to index
     */
    public function clearSearch()
    {
        Session::forget('productSearchParams');

        return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.productSearch');
    }

    /**
     * @param string $category
     * @param bool   $single
     * @return mixed
     */
    private function productSearchParams($category = '', $single = false)
    {
        if (isset($_POST) && count($_POST) > 0)
        {
            $productSearchParams = Input::all();
            Session::put('productSearchParams', $productSearchParams);
        }
        else
        {
            $productSearchParams = Session::get('productSearchParams');
            if (Input::get('color')) $productSearchParams['color'] = Input::get('color');
            if (Input::get('size')) $productSearchParams['size'] = Input::get('size');
            if (Input::get('type')) $productSearchParams['type'] = Input::get('type');
        }

        if (!$single)
        {
            if ($category) $productSearchParams['category'] = $category;

            if (isset($_GET['page']))
            {
                $productSearchParams['offset'] = $_GET['page'] - 1;
            }

            if (Input::get('searchString'))
            {
                $productSearchParams['search_string'] = Input::get('searchString');
            }

            if (Input::get('sku'))
            {
                $productSearchParams['sku'] = Input::get('sku');
            }

            $productSearchParams['limit'] = Input::get('limit', 12);
            $productSearchParams['order_by'] = Config::get('vendirun.productDefaultSortBy', 'price');
            $productSearchParams['order_direction'] = Config::get('vendirun.productDefaultSortOrder', 'ASC');

            if (Input::has('order_by'))
            {
                $searchArray = explode("_", Input::get('order_by'));
                $productSearchParams['order_by'] = $searchArray[0];
                $productSearchParams['order_direction'] = (count($searchArray) == 2) ? $searchArray[1] : 'ASC';
            }
        }

        return $productSearchParams;
    }
}