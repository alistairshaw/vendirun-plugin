<?php namespace AlistairShaw\Vendirun\App\Entities\Cart;

interface CartRepository {

    /**
     * @param Cart $cart
     * @return Cart
     */
    public function save($cart);

    /**
     * @param null $countryId
     * @param string $shippingType
     * @return Cart
     */
    public function find($countryId = null, $shippingType = '');

    /**
     * @param array $items
     * @return array
     */
    public function getProducts($items);

}