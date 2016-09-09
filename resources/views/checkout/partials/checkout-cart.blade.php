<div class="checkout-cart">
    @include('vendirun::product.partials.cart.cart-list')
    <div class="checkout-summary">
        <table class="table">
            <tr>
                <td>SubTotal</td>
                <td class="js-display-total">{{ $displayTotals->displayTotal }}</td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td class="js-display-shipping">{{ $displayTotals->displayShipping }}</td>
            </tr>
            @if (!$cart->getPriceIncludesTax())
                <tr>
                    <td>Tax</td>
                    <td class="js-tax">{{ $displayTotals->tax }}</td>
                </tr>
            @endif
            <tr>
                <td>Total</td>
                <td class="js-total">{{ $displayTotals->total }}</td>
            </tr>
        </table>
    </div>
</div>