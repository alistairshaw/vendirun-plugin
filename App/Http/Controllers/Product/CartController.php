<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\Cart\Cart;
use Redirect;
use Session;

class CartController extends VendirunBaseController {

    public function index()
    {
        echo '<h1>Cart List</h1>';
        $cart = new Cart();
        dd($cart->getProducts());
    }

    public function add($productVariationId)
    {
        $cart = new Cart();
        $cart->add($productVariationId);
        
        //Session::flash('vendirun-alert-success', 'Item Added to Cart');
        //if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));
        //return Redirect::back();
    }

}