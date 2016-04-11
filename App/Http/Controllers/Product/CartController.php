<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\Cart\Cart;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Config;
use Redirect;
use Request;
use Session;
use View;

class CartController extends VendirunBaseController {

    public function index()
    {
        $this->setPrimaryPath();

        $cart = new Cart([], Request::input('countryId', $this->_getDefaultCountry()), Request::input('shippingType', null));
        $data['cart'] = $cart->getProducts();

        return View::make('vendirun::product.cart', $data);
    }

    /**
     * @param null $productVariationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($productVariationId = null)
    {
        if (!$productVariationId) $productVariationId = Request::input('productVariationId');
        $quantity = Request::input('quantity', 1);

        $cart = new Cart();
        for ($i = 1; $i <= $quantity; $i++)
        {
            $cart->add($productVariationId);
        }

        Session::flash('vendirun-alert-success', 'Item Added to Cart');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        return Redirect::back();
    }

    /**
     * @param null $productVariationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($productVariationId = null)
    {
        $cart = new Cart();
        $cart->remove($productVariationId);

        Session::flash('vendirun-alert-success', 'Item Removed from Cart');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        return Redirect::back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        $cart = new Cart();
        $cart->clear();

        Session::flash('vendirun-alert-success', 'Cart Emptied');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        return Redirect::back();
    }

    private function _getDefaultCountry()
    {
        // if user is logged in, get their primary address country
        if (Session::has('token'))
        {
            $customer = VendirunApi::makeRequest('customer/find', ['token' => Session::get('token')])->getData();
            if (count($customer->primary_address) > 0 && $customer->primary_address->country_id)
            {
                return $customer->primary_address->country_id;
            }
        }

        // get company default country
        $clientInfo = Config::get('clientInfo');
        if ($clientInfo->country_id) return $clientInfo->country_id;

        // use UK as super-default if company default not set
        return 79;
    }
}