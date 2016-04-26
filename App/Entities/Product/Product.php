<?php namespace AlistairShaw\Vendirun\App\Entities\Product;

use AlistairShaw\Vendirun\App\Entities\Product\ProductVariation\ProductVariation;
use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;

class Product {

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var string
     */
    private $productType;

    /**
     * @var string
     */
    private $shortDescription;

    /**
     * @var string
     */
    private $longDescription;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var array
     */
    private $images;

    /**
     * @var string
     */
    private $video;

    /**
     * Collection of Product objects
     * @var array
     */
    private $relatedProducts;

    /**
     * Collection of Shipping objects
     * @var array
     */
    private $shipping;

    /**
     * Collection of ProductVariation objects
     * @var array
     */
    private $variations;

    /**
     * Product constructor.
     * @param $params | required: id, productName, productType, shortDescription, longDescription
     */
    public function __construct($params)
    {
        $this->id = $params['id'];
        $this->productName = $params['productName'];
        $this->productType = $params['productType'];
        $this->shortDescription = $params['shortDescription'];
        $this->longDescription = $params['longDescription'];

        if (isset($params['keywords'])) $this->keywords = $params['keywords'];
        if (isset($params['images'])) $this->images = $params['images'];
        if (isset($params['video'])) $this->video = $params['video'];
        if (isset($params['relatedProducts'])) $this->relatedProducts = $params['relatedProducts'];
        if (isset($params['shipping'])) $this->shipping = $params['shipping'];
        if (isset($params['variations'])) $this->variations = $params['variations'];
    }

    /**
     * @return array
     */
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * @return array
     */
    public function getRelatedProducts()
    {
        return $this->relatedProducts ? $this->relatedProducts : [];
    }

    /**
     * @param $productVariationId
     * @return ProductVariation
     */
    public function getVariation($productVariationId = NULL)
    {
        if (!$this->variations || count($this->variations) == 0) return false;
        foreach ($this->variations as $variation)
        {
            if ($variation->getId() == $productVariationId) return $variation;
        }

        return $this->variations[0];
    }

    /**
     * @return array
     */
    public function getDisplayArray()
    {
        return [
            'id' => $this->id,
            'productName' => $this->productName,
            'shortDescription' => $this->shortDescription,
            'longDescription' => $this->longDescription,
            'price' => CurrencyHelper::formatWithCurrency($this->getPrice()),
            'keywords' => $this->keywords,
            'images' => $this->images,
            'video' => $this->video,
            'variations' => $this->displayVariations()
        ];
    }

    /**
     * Returns the cheapest variation price
     * @return int
     */
    private function getPrice()
    {
        $price = NULL;
        if (!$this->variations) return $price;
        foreach ($this->variations as $variation)
        {
            if ($price === NULL || $variation->getPrice() < $price) $price = $variation->getPrice();
        }

        return $price;
    }

    /**
     * @return array
     */
    private function displayVariations()
    {
        $final = [];
        foreach ($this->variations as $variation) $final[] = $variation->display();

        return $final;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

}