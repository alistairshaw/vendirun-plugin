<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use View;

class RecommendController extends VendirunBaseController {

    public function index($productId)
    {
        $data = [];
        try
        {
            $data['product'] = VendirunApi::makeRequest('product/product', ['id' => $productId])->getData();
        }
        catch (FailResponseException $e)
        {
            if (App::environment() == 'production') abort(404);
        }

        return View::make('vendirun::product.recommend', $data);
    }

}