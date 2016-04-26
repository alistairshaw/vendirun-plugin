<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;

class ProductController extends ApiBaseController {

    /**
     * @param $productId
     * @return array
     */
    public function getVariations($productId)
    {
        $searchParams = [
            'id' => $productId
        ];
        $product = VendirunApi::makeRequest('product/product', $searchParams)->getData();

        return $this->respond(true, $product);
    }

}