<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Cache;
use Illuminate\View\View;
use Session;

class ProductViewComposer {

    /**
     * @param View $view
     */
    public function productView(View $view)
    {
        $viewData = $view->getData();
        $product = $viewData['product'];

        $view->with('price', CurrencyHelper::formatWithCurrency($product->price, true));
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
    public function colors(View $view)
    {
        $viewData = $view->getData();
        $data['category'] = (isset($viewData['category'])) ? $viewData['category'] : '';
        $data['size'] = (isset($viewData['selectedSize'])) ? $viewData['selectedSize'] : '';
        $data['type'] = (isset($viewData['selectedType'])) ? $viewData['selectedType'] : '';
        $data['locale'] = App::getLocale();
        $colors = VendirunApi::makeRequest('product/colors', $data)->getData();
        $view->with('colors', $colors)->with('category', $data['category']);
    }

    /**
     * @param View $view
     */
    public function sizes(View $view)
    {
        $viewData = $view->getData();
        $data['category'] = (isset($viewData['category'])) ? $viewData['category'] : '';
        $data['color'] = (isset($viewData['selectedColor'])) ? $viewData['selectedColor'] : '';
        $data['type'] = (isset($viewData['selectedType'])) ? $viewData['selectedType'] : '';
        $data['locale'] = App::getLocale();
        $sizes = VendirunApi::makeRequest('product/sizes', $data)->getData();
        $view->with('sizes', $sizes)->with('category', $data['category']);
    }

    /**
     * @param View $view
     */
    public function types(View $view)
    {
        $viewData = $view->getData();
        $data['category'] = (isset($viewData['category'])) ? $viewData['category'] : '';
        $data['color'] = (isset($viewData['selectedColor'])) ? $viewData['selectedColor'] : '';
        $data['size'] = (isset($viewData['selectedSize'])) ? $viewData['selectedSize'] : '';
        $data['locale'] = App::getLocale();
        $types = VendirunApi::makeRequest('product/types', $data)->getData();
        $view->with('types', $types)->with('category', $data['category']);
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

        $view->with('productButtons', $productButtons);
        if (!isset($viewData['abbreviatedButtons'])) $view->with('abbreviatedButtons', false);
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

        //dd($favouriteProductsArray);

        $view->with('favouriteProducts', $favouriteProducts)->with('favouriteProductsArray', $favouriteProductsArray);
    }

}