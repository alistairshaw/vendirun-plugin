<?php namespace AlistairShaw\Vendirun\App\Listeners;

use AlistairShaw\Vendirun\App\Lib\Cart\Cart;
use Session;

class UpdateShoppingCart
{
    /**
     * @param  $token
     * @return void
     */
    public function handle($token)
    {
        Session::put('token', $token->token);

        $cart = new Cart();
        $cart->updateApi();
    }
}