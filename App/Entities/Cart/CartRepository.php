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
     * @param $ids
     * @return object
     */
    public function getProducts($ids);

    /**
     * @return bool
     */
    public function clear();

}