<?php namespace AlistairShaw\Vendirun\App\Entities\Product;

use AlistairShaw\Vendirun\App\Entities\Product\ProductSearchResult\ProductSearchResult;

interface ProductRepository {

    /**
     * @param       $productId
     * @param array $searchParams
     * @return Product
     */
    public function find($productId, $searchParams = []);

    /**
     * @param $searchParams
     * @return ProductSearchResult
     */
    public function search($searchParams);

    /**
     * @param $productVariationId
     * @return mixed
     */
    public function findByVariationId($productVariationId);

}