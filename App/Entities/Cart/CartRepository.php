<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

interface CartRepository {

    /**
     * @param $id
     * @return mixed
     */
    public function add($id);

    /**
     * @param $id
     * @return mixed
     */
    public function remove($id);

    /**
     * @param $items
     * @return bool
     */
    public function saveCart($items);

    /**
     * @return array
     */
    public function getCart();

    /**
     * @return object
     */
    public function getProducts();

    /**
     * @return bool
     */
    public function clear();

}