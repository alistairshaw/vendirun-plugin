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
        $categories = VendirunApi::makeRequest('product/category', ['locale' => App::getLocale()]);
        $view->with('categories', $categories->getData()->sub_categories);
    }

}