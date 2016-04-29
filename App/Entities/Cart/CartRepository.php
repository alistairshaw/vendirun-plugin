<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

interface CartRepository {

    /**
     * @param Cart $cart
     * @return Cart
     */
    public function save($cart);

    /**
     * @return Cart
     */
    public function find();

    /**
     * @param array $items
     * @return array
     */
    public function getProducts($items);

}