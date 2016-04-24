<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductCategory;

class ProductCategoryFactory {

    /**
     * @param        $data
     * @param string $parentSlug
     * @param string $parentName
     * @return ProductCategory
     */
    public function fromApi($data, $parentSlug = '', $parentName = '')
    {
        if (isset($data->parent)) $parentSlug = $data->parent->slug;
        if (isset($data->parent)) $parentName = $data->parent->category_name;

        $cat = [
            'categoryName' => $data->category_name,
            'categoryDescription' => $data->category_description,
            'parent' => $parentSlug,
            'parentName' => $parentName,
            'slug' => $data->slug,
            'productCount' => isset($data->product_count) ? $data->product_count : 0,
            'translations' => isset($data->translations) ?  json_decode($data->translations, true) : []
        ];

        $cat['children'] = (isset($data->sub_categories)) ? $this->getChildren($data->sub_categories, $data->slug, $data->category_name) : [];

        return new ProductCategory($cat);
    }

    /**
     * @param        $sub_categories
     * @param string $parentSlug
     * @param string $parentName
     * @return array
     */
    private function getChildren($sub_categories, $parentSlug = '', $parentName = '')
    {
        $final = [];
        foreach ($sub_categories as $cat) $final[] = $this->fromApi($cat, $parentSlug, $parentName);
        return $final;
    }

}