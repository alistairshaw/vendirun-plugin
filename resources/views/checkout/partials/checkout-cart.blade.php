<div class="checkout-cart">
    @include('vendirun::product.partials.cart.cart-list')
    <div class="checkout-summary">
        <table class="table">
            <tr>
                <td>SubTotal</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->displayTotal()) }}</td>
            </tr>
            @if (!$cart->getPriceIncludesTax())
            <tr>
                <td>Tax</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->tax()) }}</td>
            </tr>
            @endif
            <tr>
                <td>Shipping</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->displayShipping()) }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->total()) }}</td>
            </tr>
        </table>
    </div>
</div>