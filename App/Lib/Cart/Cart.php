<?php namespace AlistairShaw\Vendirun\App\Lib\Cart;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Session;

class Cart {

    /**
     * @var array
     */
    protected $items;

    /**
     * Cart constructor.
     * @param array $items
     */
    public function __construct($items = [])
    {
        if (count($items))
        {
            $this->items = $items;
        }
        else
        {
            $this->items = Session::get('shoppingCart', []);
        }
    }

    /**
     * @param $productVariationId
     */
    public function add($productVariationId)
    {
        $this->items[] = $productVariationId;
        $this->persist();
    }

    /**
     * @param $productVariationId
     */
    public function remove($productVariationId)
    {
        $newItems = [];
        $removed = false;
        foreach ($this->items as $item)
        {
            if ($item !== $productVariationId || $removed)
            {
                $newItems[] = $item;
            }
            else
            {
                $removed = true;
            }
        }
        $this->items = $newItems;
        $this->persist();
    }

    /**
     * @return object
     */
    public function getProducts()
    {
        if (count($this->items) == 0) return null;
        return VendirunApi::makeRequest('product/search', ['variation_list_only' => implode(",", $this->items)])->getData();
    }

    private function persist()
    {
        Session::put('shoppingCart', $this->items);
        Session::save();
    }
}