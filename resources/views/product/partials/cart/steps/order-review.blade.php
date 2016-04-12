<div class="order-review">
    <table class="table">
        <tr>
            <td>{{ trans('vendirun::checkout.subTotal') }}</td>
            <td>{{ CurrencyHelper::formatWithCurrency($cart->subTotal) }}</td>
        </tr>
        <tr>
            <td>{{ trans('vendirun::checkout.shipping') }}</td>
            <td>{{ CurrencyHelper::formatWithCurrency($cart->shipping) }}</td>
        </tr>
        <tr>
            <td>{{ trans('vendirun::checkout.tax') }}</td>
            <td>{{ CurrencyHelper::formatWithCurrency($cart->tax) }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th>{{ trans('vendirun::checkout.total') }}</th>
            <th>{{ CurrencyHelper::formatWithCurrency($cart->total + $cart->shipping) }}</th>
        </tr>
    </table>
</div>