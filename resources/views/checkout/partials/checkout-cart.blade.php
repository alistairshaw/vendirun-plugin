<div class="checkout-cart">
    @include('vendirun::product.partials.cart.cart-list')
    <div class="checkout-summary">
        <table class="table">
            <tr>
                <td>SubTotal</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->total) }}</td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->shipping) }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->total + $cart->shipping) }}</td>
            </tr>
        </table>
    </div>
</div>