<?php namespace AlistairShaw\Vendirun\App\Listeners;

use AlistairShaw\Vendirun\App\Entities\Cart\CartFactory;
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

        $cartRepository->saveCart(Session::get('shoppingCart'));
    }
}