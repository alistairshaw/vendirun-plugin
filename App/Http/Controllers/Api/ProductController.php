<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Entities\Product\ProductRepository;

class ProductController extends ApiBaseController {

    /**
     * @param ProductRepository $productRepository
     * @param                   $productId
     * @return array
     */
    public function find(ProductRepository $productRepository, $productId)
    {
        return $this->respond(true, $productRepository->find($productId)->getDisplayArray());
    }

}