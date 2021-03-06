<?php namespace AlistairShaw\Vendirun\App\Entities\Product;

use AlistairShaw\Vendirun\App\Entities\Product\ProductSearchResult\ProductSearchResult;
use AlistairShaw\Vendirun\App\Entities\Product\ProductSearchResult\ProductSearchResultFactory;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;

class ApiProductRepository implements ProductRepository {

    /**
     * @param       $productId
     * @param array $searchParams
     * @return Product
     */
    public function find($productId, $searchParams = [])
    {
        $searchParams['id'] = $productId;
        $productFactory = new ProductFactory();
        return $productFactory->fromApi(VendirunApi::makeRequest('product/product', $searchParams)->getData());
    }

    /**
     * @param $searchParams
     * @return ProductSearchResult
     */
    public function search($searchParams)
    {
        $productSearchResultFactory = new ProductSearchResultFactory();
        try
        {
            return $productSearchResultFactory->fromApi(VendirunApi::makeRequest('product/search', $searchParams)->getData());
        }
        catch (FailResponseException $e)
        {
            return $productSearchResultFactory->emptyResult();
        }
    }

    /**
     * @param $productVariationId
     * @return mixed
     */
    public function findByVariationId($productVariationId)
    {
        $searchParams['product_variation_id'] = $productVariationId;
        $productFactory = new ProductFactory();
        return $productFactory->fromApi(VendirunApi::makeRequest('product/product', $searchParams)->getData());
    }
}