<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Product\ProductRepository;
use AlistairShaw\Vendirun\App\Exceptions\CustomerNotFoundException;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use App;
use View;

class RecommendController extends VendirunBaseController {

    /**
     * @param ProductRepository $productRepository
     * @param CustomerRepository $customerRepository
     * @param $productId
     * @return \Illuminate\Contracts\View\View
     */
    public function index(ProductRepository $productRepository, CustomerRepository $customerRepository, $productId)
    {
        $data = [];
        try
        {
            $data['product'] = $productRepository->find($productId);
        }
        catch (FailResponseException $e)
        {
            if (App::environment() == 'production') abort(404);
        }

        try
        {
            $data['customer'] = $customerRepository->find();
        }
        catch (CustomerNotFoundException $e)
        {
            // this exception means we're not logged in. No problem
        }

        $data['recommend'] = true;
        $data['pageTitle'] = trans('vendirun::product.sendProductToFriend');

        return View::make('vendirun::product.recommend', $data);
    }

}