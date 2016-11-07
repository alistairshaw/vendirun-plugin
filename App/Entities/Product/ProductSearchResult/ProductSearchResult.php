<?php namespace AlistairShaw\Vendirun\App\Entities\Product\ProductSearchResult;

class ProductSearchResult {

    /**
     * @var array
     */
    private $products;

    /**
     * @var int
     */
    private $totalRows;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var array
     */
    private $searchParams;

    /**
     * @var array
     */
    private $availableColors;

    /**
     * @var array
     */
    private $availableTypes;

    /**
     * @var array
     */
    private $availableSizes;

    /**
     * @var array
     */
    private $breadcrumbs;

    /**
     * @param array $params | required: products, totalRows, limit, offset
     */
    public function __construct($params)
    {
        $this->products = $params['products'];
        $this->totalRows = $params['totalRows'];
        $this->limit = $params['limit'];
        $this->offset = $params['offset'];

        $this->searchParams = (isset($params['searchParams'])) ? $params['searchParams'] : [];
        $this->availableColors = (isset($params['availableColors'])) ? $params['availableColors'] : [];
        $this->availableTypes = (isset($params['availableTypes'])) ? $params['availableTypes'] : [];
        $this->availableSizes = (isset($params['availableSizes'])) ? $params['availableSizes'] : [];
        $this->breadcrumbs = (isset($params['breadcrumbs'])) ? $params['breadcrumbs'] : [];
    }

    /**
     * @param $fieldName
     * @return mixed
     */
    public function getSearchParam($fieldName)
    {
        foreach ($this->searchParams as $index => $val)
        {
            if ($index == $fieldName) return $val;
        }

        return '';
    }

    /**
     * @return array|mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return int
     */
    public function getTotalRows()
    {
        return $this->totalRows;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return array
     */
    public function getAvailableColors()
    {
        return $this->availableColors;
    }

    /**
     * @return array
     */
    public function getAvailableTypes()
    {
        return $this->availableTypes;
    }

    /**
     * @return array
     */
    public function getAvailableSizes()
    {
        return $this->availableSizes;
    }

    /**
     * @return array
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

}