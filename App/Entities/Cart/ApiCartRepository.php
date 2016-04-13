<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Session;

class ApiCartRepository implements CartRepository {

    /**
     * @param $id
     * @return bool
     */
    public function add($id)
    {
        $items = $this->getCart();
        $items[] = $id;
        return $this->saveCart($items);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        $newItems = [];
        $removed = false;
        foreach ($this->getCart() as $item)
        {
            if ($item == $id && !$removed)
            {
                $removed = true;
            }
            else
            {
                $newItems[] = $item;
            }
        }
        return $this->saveCart($newItems);
    }

    /**
     * @param array $items
     * @return bool
     */
    public function saveCart($items)
    {
        Session::put('shoppingCart', $items);
        Session::save();

        if (Session::has('token'))
        {
            try
            {
                $data = [
                    'token' => Session::get('token'),
                    'ids' => $items
                ];
                VendirunApi::makeRequest('cart/update', $data)->getData();
            }
            catch (FailResponseException $e)
            {
                // API fail, maybe not logged in properly or token expired
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getCart()
    {
        if (Session::has('shoppingCart')) return Session::get('shoppingCart');
        if (!Session::has('token')) return [];

        try
        {
            $data = [
                'token' => Session::get('token')
            ];
            $items = $this->getItemListFromApiReturn(VendirunApi::makeRequest('cart/fetch', $data)->getData());
        }
        catch (FailResponseException $e)
        {
            // if token is invalid
            $items = [];
        }
        
        return $items;
    }

    /**
     * @param $items
     * @return array
     */
    private function getItemListFromApiReturn($items)
    {
        $newItems = [];
        foreach ($items as $item)
        {
            for ($i = 1; $i <= $item->quantity; $i++)
            {
                $newItems[] = $item->product_variation_id;
            }
        }
        return $newItems;
    }

    /**
     * @param $productVariationIds
     * @return object
     */
    public function getProducts($productVariationIds)
    {
        return VendirunApi::makeRequest('product/search', ['variation_list_only' => implode(",", $productVariationIds)])->getData();
    }

    /**
     * @return bool
     */
    public function clear()
    {
        return $this->saveCart([]);
    }
}