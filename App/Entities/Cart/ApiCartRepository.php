<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

use AlistairShaw\Vendirun\App\Entities\Cart\CartItem\CartItem;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Session;

class ApiCartRepository implements CartRepository {

    /**
     * @param Cart $cart
     * @return Cart
     * @throws FailResponseException
     */
    public function save($cart)
    {
        $items = $cart->getItems();
        $itemIds = [];
        foreach ($items as $cartItem)
        {
            /* @var $cartItem CartItem */
            for ($i = 1; $i <= $cartItem->getQuantity(); $i++)
            {
                $itemIds[] = $cartItem->getVariationId();
            }
        }
        Session::put('shoppingCart', $itemIds);

        if ($token = CustomerHelper::checkLoggedinCustomer())
        {
            try
            {
                $data = [
                    'token' => $token,
                    'ids' => $itemIds
                ];
                VendirunApi::makeRequest('cart/update', $data)->getData();
            }
            catch (FailResponseException $e)
            {
                // API fail, maybe not logged in properly or token expired
                //    doesn't matter, we just can't save the cart details to Vendirun
            }
        }

        return $this->find();
    }

    /**
     * @return Cart
     */
    public function find()
    {
        $cartFactory = new CartFactory($this);

        if (Session::has('shoppingCart')) return $cartFactory->makeFromIds(Session::get('shoppingCart'));
        if (!CustomerHelper::checkLoggedinCustomer()) return $cartFactory->makeFromIds([]);

        try
        {
            $data = [
                'token' => Session::get('token')
            ];
            $result = VendirunApi::makeRequest('cart/fetch', $data)->getData();
            $items = $this->getItemListFromApiReturn($result->items);
        }
        catch (FailResponseException $e)
        {
            // if token is invalid
            $items = [];
        }

        return $cartFactory->makeFromIds($items);
    }

    /**
     * @param array $items
     * @return object
     */
    public function getProducts($items)
    {
        return VendirunApi::makeRequest('product/search', ['variation_list_only' => implode(",", $items)])->getData();
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
}