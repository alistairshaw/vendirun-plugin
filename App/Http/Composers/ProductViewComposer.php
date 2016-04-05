<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Illuminate\View\View;

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
        $category = (isset($viewData['category'])) ? $viewData['category'] : '';
        $colors = VendirunApi::makeRequest('product/colors', ['locale' => App::getLocale(), 'category' => $category])->getData();
        $view->with('colors', $colors)->with('category', $category);
    }

}