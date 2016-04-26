<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductCategory;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;

class ApiProductCategoryRepository implements ProductCategoryRepository {

    /**
     * @param string $slug
     * @return ProductCategory
     */
    public function find($slug)
    {
        $factory = new ProductCategoryFactory();
        return $factory->fromApi(VendirunApi::makeRequest('product/category', ['locale' => App::getLocale(), 'category' => $slug])->getData());
    }
}