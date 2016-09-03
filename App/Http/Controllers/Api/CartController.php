<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItemFactory;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Product\ProductRepository;
use AlistairShaw\Vendirun\App\Exceptions\InvalidProductVariationIdException;
use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use Config;
use Request;

class CartController extends ApiBaseController {

    /**
     * Returns cart adjusted based on country or shipping type
     * @param CartRepository $cartRepository
     * @return array
     */
    public function calculate(CartRepository $cartRepository)
    {
        try
        {
            $cart = $cartRepository->find(Request::get('countryId', null), Request::get('shippingTypeId', ''));

            return $this->respond(true, $cart->toArray());
        }
        catch (\Exception $e)
        {
            return $this->respond(false);
        }
    }

    /**
     * @param CartRepository    $cartRepository
     * @param ProductRepository $productRepository
     * @return array
     */
    public function add(CartRepository $cartRepository, ProductRepository $productRepository)
    {
        $productVariationId = Request::get('productVariationId', 0);
        $quantity = Request::get('quantity', 1);

        try
        {
            $cart = $cartRepository->find();
            $product = $productRepository->findByVariationId($productVariationId);

            $clientInfo = Config::get('clientInfo');
            $priceIncludesTax = $clientInfo->business_settings->tax->price_includes_tax;
            $cartItemFactory = new CartItemFactory($cartRepository, $cart);
            $cartItem = $cartItemFactory->make($product, $priceIncludesTax, $quantity);
            $cart->add($cartItem);
            $cart = $cartRepository->save($cart);

            return $this->respond(true, $cart->toArray());
        }
        catch (\Exception $e)
        {
            return $this->respond(false, [], $e->getMessage());
        }
    }

    /**
     * @param CartRepository $cartRepository
     * @return array
     */
    public function remove(CartRepository $cartRepository)
    {
        $productVariationId = Request::get('productVariationId', 0);
        $quantity = Request::get('quantity', 1);

        try
        {
            $cart = $cartRepository->find();
            $cart->remove($productVariationId, $quantity);
            $cart = $cartRepository->save($cart);

            return $this->respond(true, $cart->toArray());
        }
        catch (\Exception $e)
        {
            return $this->respond(false, [], $e->getMessage());
        }
    }

}