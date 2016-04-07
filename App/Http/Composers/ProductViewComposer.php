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

}