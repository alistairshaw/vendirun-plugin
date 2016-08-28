<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Lib\ClientHelper;
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
    public function categories(View $view)
    {
        $viewData = $view->getData();

        $parent = (isset($viewData['productSearchResult'])) ? $viewData['productSearchResult']->getSearchParam('category') : '';
        $productCategoryRepository = App::make('AlistairShaw\Vendirun\App\Entities\Product\ProductCategory\ProductCategoryRepository');
        $view->with('currentCategory', $productCategoryRepository->find($parent)->display());
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
        $viewProductRoute = $this->getProductRoute($viewData['productDisplay']['id'], $viewData['productDisplay']['productName']);

        $view->with('productButtons', $productButtons)->with('viewProductRoute', $viewProductRoute);
        if (!isset($viewData['abbreviatedButtons'])) $view->with('abbreviatedButtons', false);
    }

    /**
     * @param View $view
     */
    public function productView(View $view)
    {
        $viewData = $view->getData();
        if (!isset($viewData['productDisplay']))
        {
            $product = $viewData['product'];
            /* @var $product Product */
            $viewData['productDisplay'] = $product->getDisplayArray();
            $view->with('productDisplay', $viewData['productDisplay']);
        }

        $view->with('viewProductRoute', $this->getProductRoute($viewData['productDisplay']['id'], $viewData['productDisplay']['productName']));
    }

    /**
     * @param      $productId
     * @param      $productName
     * @param int $variationId
     * @param bool $addToCart
     * @return string
     */
    private function getProductRoute($productId, $productName, $variationId = 0, $addToCart = false)
    {
        return route(LocaleHelper::localePrefix() . $addToCart ? 'vendirun.productAddToCart' : 'vendirun.productView'
            , array_merge(
                ['productId' => $productId, 'productName' => urlencode(strtolower($productName)), 'variationId' => $variationId]
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
            $cartRepository = App::make('AlistairShaw\Vendirun\App\Entities\Cart\CartRepository');
            $view->with('cart', $cartRepository->find());
        }
    }

    public function checkout(View $view)
    {
        $paymentGateways = ClientHelper::getPaymentGatewayInfo();
        $view->with('paymentGateways', $paymentGateways);
    }
}