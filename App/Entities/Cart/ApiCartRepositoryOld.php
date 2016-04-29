<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Exceptions\InvalidProductVariationIdException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Session;

class ApiCartRepositoryOld implements CartRepository {

    /**
     * @param $id
     * @return bool
     * @throws InvalidProductVariationIdException
     */
    public function add($id)
    {
        if (!$id)
        {
            throw new InvalidProductVariationIdException('Invalid Product Variation ID Passed');
        }
        $items = $this->getCart();
        $items[] = (int)$id;
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
     * @param $items
     * @return bool
     * @throws \Exception
     */
    public function saveCart($items)
    {
        if (!is_array($items)) throw new \Exception('Invalid cart items passed to repository');
        if (count($items) == 0)
        {
            Session::put('shoppingCart', []);
        }
        else
        {
            if (!is_int($items[0])) throw new \Exception('Invalid cart item passed to repository');
            Session::put('shoppingCart', $items);
        }
        Session::save();

        if ($token = CustomerHelper::checkLoggedinCustomer())
        {
            try
            {
                $data = [
                    'token' => $token,
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
        if (!CustomerHelper::checkLoggedinCustomer()) return [];

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
     * @return object
     */
    public function getProducts()
    {
        return VendirunApi::makeRequest('product/search', ['variation_list_only' => implode(",", $this->getCart())])->getData();
    }

    /**
     * @return bool
     */
    public function clear()
    {
        return $this->saveCart([]);
    }
}