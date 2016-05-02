<?php namespace AlistairShaw\Vendirun\App\Listeners;

use App;
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

        $cartRepository = App::make('AlistairShaw\Vendirun\App\Entities\Cart\CartRepository');
        $cart = $cartRepository->find();
        $cartRepository->save($cart);
    }
}