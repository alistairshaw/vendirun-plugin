<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use Redirect;
use Request;
use Session;
use View;

class CartController extends VendirunBaseController {

    public function index(CartRepository $cartRepository)
    {
        $this->setPrimaryPath();

        $cartFactory = new CartFactory($cartRepository);
        $data['cart'] = $cartFactory->make(Request::input('countryId', null), Request::input('shippingType', null));

        return View::make('vendirun::product.cart', $data);
    }

    /**
     * @param null           $productVariationId
     * @param CartRepository $cartRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($productVariationId = null, CartRepository $cartRepository)
    {
        if (!$productVariationId) $productVariationId = Request::input('productVariationId');
        $quantity = Request::input('quantity', 1);

        for ($i = 1; $i <= $quantity; $i++)
        {
            $cartRepository->add($productVariationId);
        }

        Session::flash('vendirun-alert-success', 'Item Added to Cart');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        return Redirect::back();
    }

    /**
     * @param null           $productVariationId
     * @param CartRepository $cartRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($productVariationId = null, CartRepository $cartRepository)
    {
        $cartRepository->remove($productVariationId);

        Session::flash('vendirun-alert-success', 'Item Removed from Cart');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        return Redirect::back();
    }

    /**
     * @param CartRepository $cartRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear(CartRepository $cartRepository)
    {
        $cartRepository->clear();

        Session::flash('vendirun-alert-success', 'Cart Emptied');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        return Redirect::back();
    }
}