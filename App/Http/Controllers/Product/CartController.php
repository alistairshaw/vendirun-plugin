<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Product;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItemFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesTransformer;
use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Entities\Product\ProductRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\TaxHelper;
use AlistairShaw\Vendirun\App\Providers\VendirunServiceProvider;
use App;
use Config;
use Mockery\CountValidator\Exception;
use Redirect;
use Request;
use Session;
use View;

class CartController extends VendirunBaseController {

    /**
     * @param CartRepository $cartRepository
     * @param CustomerRepository $customerRepository
     * @param CartValuesTransformer $transformer
     * @return mixed
     */
    public function index(CartRepository $cartRepository, CustomerRepository $customerRepository, CartValuesTransformer $transformer)
    {
        $this->setPrimaryPath();

        $countryId = Request::get('countryId', null);
        if (!$countryId) $countryId = CustomerHelper::getDefaultCountry($customerRepository);

        $data['cart'] = $cartRepository->find($countryId);
        $data['cartValues'] = $data['cart']->getValues($transformer);

        return View::make('vendirun::product.cart', $data);
    }

    /**
     * @param CartRepository    $cartRepository
     * @param ProductRepository $productRepository
     * @param int               $productVariationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(CartRepository $cartRepository, ProductRepository $productRepository, $productVariationId = NULL)
    {
        try
        {
            $productVariationId = Request::get('productVariationId', $productVariationId);

            $cart = $cartRepository->find();
            $product = $productRepository->findByVariationId($productVariationId);

            $clientInfo = Config::get('clientInfo');
            $priceIncludesTax = $clientInfo->business_settings->tax->price_includes_tax;
            $cartItemFactory = new CartItemFactory($cartRepository, $cart);
            $cartItem = $cartItemFactory->make($product, $priceIncludesTax, Request::input('quantity', 1));
            $cart->add($cartItem);
            $cartRepository->save($cart);
        }
        catch (Exception $e)
        {
            Session::flash('vendirun-alert-error', 'Unable to add your item to the cart. ' . $e->getMessage());
            return Redirect::back();
        }

        Session::flash('vendirun-alert-success', 'Item Added to Cart');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));

        return Redirect::back();
    }

    /**
     * @param CartRepository $cartRepository
     * @param int            $productVariationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(CartRepository $cartRepository, $productVariationId = NULL)
    {
        try
        {
            $cart = $cartRepository->find();
            $cart->remove($productVariationId);
            $cartRepository->save($cart);
            Session::flash('vendirun-alert-success', 'Item Removed from Cart');
        }
        catch (Exception $e)
        {
            Session::flash('vendirun-alert-error', 'Unable to remove Item from Cart. Please refresh the page and try again.');
        }

        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));

        return Redirect::back();
    }

    /**
     * @param CartRepository $cartRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear(CartRepository $cartRepository)
    {
        $cart = $cartRepository->find();
        $cart->clear();
        $cartRepository->save($cart);

        Session::flash('vendirun-alert-success', 'Cart Emptied');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));

        return Redirect::back();
    }
}