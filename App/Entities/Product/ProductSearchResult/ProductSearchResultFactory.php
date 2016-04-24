<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductSearchResult;

use AlistairShaw\Vendirun\App\Entities\Product\ProductFactory;
use AlistairShaw\Vendirun\App\ValueObjects\Color;
use AlistairShaw\Vendirun\App\ValueObjects\Size;
use AlistairShaw\Vendirun\App\ValueObjects\Type;

class ProductSearchResultFactory {

    /**
     * @param $result
     * @return ProductSearchResult
     */
    public function fromApi($result)
    {
        $productFactory = new ProductFactory();
        $products = [];
        foreach ($result->result as $product) $products[] = $productFactory->fromApi($product);

        $colors = [];
        $types = [];
        $sizes = [];
        foreach ($result->colors as $color) $colors[] = new Color($color->name, $color->hex);
        foreach ($result->types as $type) $types[] = new Type($type->name);
        foreach ($result->sizes as $size) $sizes[] = new Size($size->name);

        return new ProductSearchResult([
            'products' => $products,
            'totalRows' => $result->total_rows,
            'limit' => $result->limit,
            'offset' => $result->offset,
            'searchParams' => $result->search_params,
            'availableColors' => $colors,
            'availableTypes' => $types,
            'availableSizes' => $sizes
        ]);
    }

}