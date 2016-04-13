<div class="order-review">
    <table class="table">
        <tr>
            <td>{{ trans('vendirun::checkout.subTotal') }}</td>
            <td>{{ CurrencyHelper::formatWithCurrency($cart->subTotal()) }}</td>
        </tr>
        <tr>
            <td>{{ trans('vendirun::checkout.shipping') }}</td>
            <td>{{ CurrencyHelper::formatWithCurrency($cart->shipping()) }}</td>
        </tr>
        @if ($cart->tax() > 0)
            <tr>
                <td>{{ trans('vendirun::checkout.tax') }}</td>
                <td>{{ CurrencyHelper::formatWithCurrency($cart->tax()) }}</td>
            </tr>
        @endif
        <tr>
            <th>{{ trans('vendirun::checkout.total') }}</th>
            <th>{{ CurrencyHelper::formatWithCurrency($cart->total()) }}</th>
        </tr>
    </table>
</div>