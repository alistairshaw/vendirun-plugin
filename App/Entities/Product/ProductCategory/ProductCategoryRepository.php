<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductCategory;

interface ProductCategoryRepository {

    /**
     * @param string $slug
     * @return ProductCategory
     */
    public function find($slug);

}