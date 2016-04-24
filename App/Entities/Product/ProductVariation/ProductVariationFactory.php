<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductVariation;

use AlistairShaw\Vendirun\App\ValueObjects\Color;
use AlistairShaw\Vendirun\App\ValueObjects\Size;
use AlistairShaw\Vendirun\App\ValueObjects\Type;

class ProductVariationFactory {

    /**
     * @param $productVariation
     * @return ProductVariation
     */
    public function fromApi($productVariation)
    {
        $params = [
            'id' => $productVariation->id,
            'name' => $productVariation->name,
            'price' => $productVariation->price,
            'sku' => $productVariation->product_sku . $productVariation->variation_sku,
            'stockLevel' => $productVariation->stock_level,
        ];

        if ($productVariation->color) $params['color'] = new Color($productVariation->color->name, $productVariation->color->hex);
        if ($productVariation->size) $params['size'] = new Size($productVariation->size->name);
        if ($productVariation->type) $params['type'] = new Type($productVariation->type->name);

        return new ProductVariation($params);
    }

}