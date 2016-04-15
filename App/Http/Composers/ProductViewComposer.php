<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Cache;
use Illuminate\View\View;
use Request;
use Session;

class ProductViewComposer {

    /**
     * @param View $view
     */
    public function productView(View $view)
    {
        $viewData = $view->getData();
        $product = $viewData['product'];

        $view->with('price', CurrencyHelper::formatWithCurrency($product->price));
    }

    /**
     * @param View $view
     */
    public function categories(View $view)
    {
        $viewData = $view->getData();

        $parent = (isset($viewData['category'])) ? $viewData['category'] : '';
        $category = VendirunApi::makeRequest('product/category', ['locale' => App::getLocale(), 'category' => $parent])->getData();
        $view->with('currentCategory', $category);
    }

    /**
     * @param View $view
     */
    public function productButtons(View $view)
    {
        $viewData = $view->getData();

        $validPropertyButtons = ['details', 'enquire', 'favourite', 'recommend', 'add-to-cart'];
        if (!isset($viewData['productButtons']))
        {
            $productButtons = $validPropertyButtons;
        }
        else
        {
            $productButtons = [];
            foreach ($viewData['productButtons'] as $button)
            {
                if (in_array($button, $validPropertyButtons)) $productButtons[] = $button;
            }
        }

        // route to view product
        $viewProductRoute = $this->getProductRoute($viewData['product']);

        $view->with('productButtons', $productButtons)->with('viewProductRoute', $viewProductRoute);
        if (!isset($viewData['abbreviatedButtons'])) $view->with('abbreviatedButtons', false);
    }

    public function productImages(View $view)
    {
        $viewData = $view->getData();

        $view->with('viewProductRoute', $this->getProductRoute($viewData['product']));
    }

    /**
     * @param      $product
     * @param int  $variationId
     * @param bool $addToCart
     * @return
     */
    private function getProductRoute($product, $variationId = 0, $addToCart = false)
    {
        return route(LocaleHelper::localePrefix() . $addToCart ? 'vendirun.productAddToCart' : 'vendirun.productView'
            , array_merge(
                ['productId' => $product->id, 'productName' => urlencode(strtolower($product->product_name)), 'variationId' => $variationId]
                , Request::query())
        );
    }

    /**
     * @param View $view
     */
    public function getFavourites(View $view)
    {
        $cacheKey = 'favourites-' . Session::get('token');

        if (!$favouriteProducts = Cache::get($cacheKey))
        {
            try
            {
                $favouriteProducts = VendirunApi::makeRequest('product/favourites', ['token' => Session::get('token')])->getData();
            }
            catch (\Exception $e)
            {
                $favouriteProducts = NULL;
            }
        }

        Cache::forever($cacheKey, $favouriteProducts);

        $favouriteProductsArray = [];
        if ($favouriteProducts) foreach ($favouriteProducts->result as $favourite) $favouriteProductsArray[] = $favourite->id;

        $view->with('favouriteProducts', $favouriteProducts)->with('favouriteProductsArray', $favouriteProductsArray);
    }

    /**
     * @param View $view
     */
    public function cart(View $view)
    {
        $viewData = $view->getData();
        if (!isset($viewData['cart']))
        {
            $cartFactory = new CartFactory(App::make('AlistairShaw\Vendirun\App\Entities\Cart\CartRepository'));
            $view->with('cart', $cartFactory->make());
        }
    }
}