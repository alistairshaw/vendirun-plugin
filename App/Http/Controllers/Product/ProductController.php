<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Entities\Product\ProductRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use App;
use Config;
use Illuminate\Pagination\LengthAwarePaginator;
use Redirect;
use Session;
use View;
use Request;

class ProductController extends VendirunBaseController {

    protected $primaryPages = true;

    /**
     * @param ProductRepository $productRepository
     * @param string            $category
     * @return \Illuminate\View\View
     */
    public function index(ProductRepository $productRepository, $category = '')
    {
        $productSearchParams = $this->productSearchParams($category);
        $data = [];
        try
        {
            $search = $productRepository->search($productSearchParams);

            $data['pagination'] = ($search->getTotalRows() > 0) ? $data['pagination'] =
                new LengthAwarePaginator(
                    $search->getProducts(),
                    $search->getTotalRows(),
                    $search->getLimit(),
                    Request::get('page'),
                    [
                        'path'  => Request::url(),
                        'query' => Request::query()
                    ]
                ) : false;

            $data['productSearchResult'] = $search;
        }
        catch (\Exception $e)
        {
            if (App::environment() == 'local') dd($e);
            abort(404);
        }

        return View::make('vendirun::product.results', $data);
    }

    /**
     * @param ProductRepository $productRepository
     * @param                   $id
     * @param string            $productName
     * @param int               $productVariationId
     * @return \Illuminate\View\View
     */
    public function view(ProductRepository $productRepository, $id, $productName = '', $productVariationId = null)
    {
        $searchParams = $this->productSearchParams();
        $searchParams['product_variation_id'] = $productVariationId;

        $data['product'] = $productRepository->find($id, $searchParams);
        $data['productDisplay'] = $data['product']->getDisplayArray();
        $data['selectedVariation'] = $data['product']->getVariation($productVariationId );

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
            $productSearchParams = Request::all();
            Session::put('productSearchParams', $productSearchParams);
        }
        else
        {
            $productSearchParams = Session::get('productSearchParams');
            if (Request::get('color')) $productSearchParams['color'] = Request::get('color');
            if (Request::get('size')) $productSearchParams['size'] = Request::get('size');
            if (Request::get('type')) $productSearchParams['type'] = Request::get('type');
        }

        if (!$single)
        {
            if ($category) $productSearchParams['category'] = $category;

            $productSearchParams['offset'] = (Request::get('page', 1) - 1) * Request::get('limit', 12);

            if (Request::has('searchString')) $productSearchParams['search_string'] = Request::get('searchString');
            if (Request::has('sku')) $productSearchParams['sku'] = Request::get('sku');

            $productSearchParams['limit'] = Request::get('limit', 12);
            $productSearchParams['order_by'] = Config::get('vendirun.productDefaultSortBy', 'price');
            $productSearchParams['order_direction'] = Config::get('vendirun.productDefaultSortOrder', 'ASC');

            if (Request::has('order_by'))
            {
                $searchArray = explode("_", Request::get('order_by'));
                $productSearchParams['order_by'] = $searchArray[0];
                $productSearchParams['order_direction'] = (count($searchArray) == 2) ? $searchArray[1] : 'ASC';
            }
        }

        return $productSearchParams;
    }
}