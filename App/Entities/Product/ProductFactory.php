<?php namespace AlistairShaw\Vendirun\App\Entities\Product;

use AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption\ProductShippingOption;
use AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption\ProductTaxOption;
use AlistairShaw\Vendirun\App\Entities\Product\ProductVariation\ProductVariationFactory;

class ProductFactory {

    /**
     * @param $product
     * @return Product
     */
    public function fromApi($product)
    {
        $params = [
            'id' => $product->id,
            'productName' => $product->product_name,
            'productType' => $product->product_type,
            'shortDescription' => $product->short_description,
            'longDescription' => $product->long_description,
            'keywords' => $product->keywords,
            'images' => $product->images,
            'video' => $product->video
        ];

        if (isset($product->shipping)) $params['shipping'] = $this->makeShipping($product->shipping);
        if (isset($product->tax)) $params['tax'] = $this->makeTax($product->tax);
        if (isset($product->variations)) $params['variations'] = $this->makeVariations($product->variations);
        if (isset($product->relatedProducts)) $params['relatedProducts'] = $this->makeRelatedProducts($product->related_products);

        return new Product($params);
    }

    /**
     * @param $apiShipping
     * @return array
     */
    private function makeShipping($apiShipping)
    {
        $shipping = [];
        foreach ($apiShipping as $item)
        {
            $shipping[] = new ProductShippingOption($item->order_price, $item->shipping_type, $item->countries, $item->weight_from, $item->weight_to);
        }
        return $shipping;
    }

    /**
     * @param $apiTax
     * @return array
     */
    private function makeTax($apiTax)
    {
        $tax = [];
        foreach ($apiTax as $item)
        {
            $tax[] = new ProductTaxOption($item->percentage, $item->countries, !$item->id);
        }
        return $tax;
    }

    /**
     * @param $apiVariations
     * @return array
     */
    private function makeVariations($apiVariations)
    {
        $variations = [];
        
        $productVariationFactory = new ProductVariationFactory();
        foreach ($apiVariations as $variation) $variations[] = $productVariationFactory->fromApi($variation);

        return $variations;
    }

    /**
     * @param $products
     * @return array
     */
    private function makeRelatedProducts($products)
    {
        $relatedProducts = [];
        foreach ($products as $product) $relatedProducts[] = $this->fromApi($product);
        return $relatedProducts;
    }

}