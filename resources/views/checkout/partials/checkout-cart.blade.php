<div class="checkout-cart">
    @include('vendirun::product.partials.cart.cart-list')
    <div class="checkout-summary">
        <table class="table">
            <tr>
                <td>SubTotal</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->displayTotal(), false, '') }}</td>
            </tr>
            @if (!$cart->getPriceIncludesTax())
            <tr>
                <td>Tax</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->tax(), false, '') }}</td>
            </tr>
            @endif
            <tr>
                <td>Shipping</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->displayShipping(), false, '') }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->total(), false, '') }}</td>
            </tr>
        </table>
    </div>
</div>