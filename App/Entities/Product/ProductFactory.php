<?php namespace AlistairShaw\Vendirun\App\Entities\Product;

use AlistairShaw\Vendirun\App\Entities\Product\ProductShippingOption\ProductShippingOption;
use AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption\ProductTaxOption;
use AlistairShaw\Vendirun\App\Entities\Product\ProductTaxOption\ProductTaxOptionFactory;
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

        if (isset($product->shipping)) $params['shipping'] = $this->makeShipping($product->shipping, $product->supplier_id);
        if (isset($product->tax)) $params['tax'] = ProductTaxOptionFactory::makeFromApi($product->tax);
        if (isset($product->variations)) $params['variations'] = $this->makeVariations($product->variations);
        if (isset($product->related_products)) $params['relatedProducts'] = $this->makeRelatedProducts($product->related_products);
        if (isset($product->categories)) $params['categories'] = $product->categories;


        return new Product($params);
    }

    /**
     * @param $apiShipping
     * @param null $supplierId
     * @return array
     */
    private function makeShipping($apiShipping, $supplierId = null)
    {
        $shipping = [];
        foreach ($apiShipping as $item)
        {
            // override with supplier prices, if applicable
            if (isset($item->supplier_prices))
            {
                foreach ($item->supplier_prices as $supplier_price)
                {
                    if ($supplier_price->supplier_id == $supplierId)
                    {
                        $item->order_price = $supplier_price->order_price;
                    }
                }
            }

            $shipping[] = new ProductShippingOption($item->order_price, $item->product_price, $item->shipping_type, $supplierId, $item->countries, $item->weight_from, $item->weight_to);
        }
        return $shipping;
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