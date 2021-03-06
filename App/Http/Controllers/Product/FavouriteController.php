<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunAuthController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Cache;
use Config;
use Illuminate\Pagination\LengthAwarePaginator;
use Redirect;
use Request;
use Session;
use View;

class FavouriteController extends VendirunAuthController {

    /**
     * @return $this
     */
    public function index()
    {
        $data = [];

        $productSearchParams['limit'] = Request::get('limit', 12);
        $productSearchParams['order_by'] = Config::get('vendirun.productDefaultSortBy', 'price');
        $productSearchParams['order_direction'] = Config::get('vendirun.productDefaultSortOrder', 'ASC');

        if (Request::has('order_by'))
        {
            $searchArray = explode("_", Request::get('order_by'));
            $productSearchParams['order_by'] = $searchArray[0];
            $productSearchParams['order_direction'] = (count($searchArray) == 2) ? $searchArray[1] : 'ASC';
        }

        try
        {
            $productSearchParams['token'] = Session::get('token');
            $productSearchParams['idsOnly'] = false;

            $data['products'] = VendirunApi::makeRequest('product/favourites', $productSearchParams)->getData();
            $data['productSearchParams'] = $productSearchParams;

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

        $data['pageTitle'] = trans('vendirun::product.favourites');

        return View::make('vendirun::product.favourites', $data);
    }

    /**
     * @param $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addFavourite($productId)
    {
        $response = VendirunApi::makeRequest('product/addFavourite', ['token' => Session::get('token'), 'product_id' => $productId]);
        Cache::forget('favourites-' . Session::get('token'));

        if (!$response->getSuccess())
        {
            Session::flash('vendirun-alert-error', $response->getError());
        }
        else
        {
            if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        }

        return Redirect::back();
    }

    /**
     * @param $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFavourite($productId)
    {
        $response = VendirunApi::makeRequest('product/removeFavourite', ['token' => Session::get('token'), 'product_id' => $productId]);
        Cache::forget('favourites-' . Session::get('token'));

        if (!$response->getSuccess())
        {
            Session::flash('vendirun-alert-error', $response->getError());
        }
        else
        {
            if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        }

        return Redirect::back();
    }

}