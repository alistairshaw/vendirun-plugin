<div class="checkout-cart">
    @include('vendirun::product.partials.cart.cart-list')
    <div class="checkout-summary">
        <table class="table">
            <tr>
                <td>{{ trans('vendirun::checkout.subTotal') }}</td>
                <td class="js-display-total">{{ $displayTotals['displayTotal'] }}</td>
            </tr>
            <tr>
                <td>{{ trans('vendirun::checkout.shipping') }}</td>
                <td class="js-display-shipping">{{ $displayTotals['displayShipping'] }}</td>
            </tr>
            @if ($displayTotals['subTotal'] != $displayTotals['displayTotal'])
                <tr>
                    <td>{{ trans('vendirun::checkout.tax') }}</td>
                    <td class="js-tax">{{ $displayTotals['tax'] }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ trans('vendirun::checkout.total') }}</td>
                <td class="js-total">{{ $displayTotals['total'] }}</td>
            </tr>
        </table>
    </div>
</div>