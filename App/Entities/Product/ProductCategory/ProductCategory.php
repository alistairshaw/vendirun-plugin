<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductCategory;

class ProductCategory {

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $categoryName;

    /**
     * @var string
     */
    private $categoryDescription;

    /**
     * @var string
     */
    private $parent;

    /**
     * @var
     */
    private $parentName;

    /**
     * @var int
     */
    private $productCount;

    /**
     * @var array
     */
    private $translations;

    /**
     * @var array
     */
    private $children;

    /**
     * @param array $params | required: slug, categoryName, categoryDescription, productCount
     */
    public function __construct($params)
    {
        $this->slug = $params['slug'];
        $this->categoryName = $params['categoryName'];
        $this->categoryDescription = $params['categoryDescription'];
        $this->parent = isset($params['parent']) ? $params['parent'] : [];
        $this->parentName = isset($params['parentName']) ? $params['parentName'] : [];
        $this->productCount = $params['productCount'];
        $this->translations = isset($params['translations']) ? $params['translations'] : [];
        $this->children = isset($params['children']) ? $params['children'] : [];
    }

    /**
     * @return array
     */
    private function getChildren()
    {
        $final = [];
        foreach ($this->children as $child)
        {
            $final[] = $child->display();
        }
        return $final;
    }

    /**
     * @return array
     */
    public function display()
    {
        return [
            'slug' => $this->slug,
            'categoryName' => $this->categoryName,
            'categoryDescription' => $this->categoryDescription,
            'parent' => $this->parent,
            'parentName' => $this->parentName,
            'productCount' => $this->productCount,
            'translations' => $this->translations,
            'children' => $this->getChildren()
        ];
    }

}