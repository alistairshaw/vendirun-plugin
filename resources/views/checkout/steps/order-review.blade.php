<div class="order-review">
    <table class="table">
        <tr>
            <td>{{ trans('vendirun::checkout.subTotal') }}</td>
            <td class="js-total-before-tax">{{ $displayTotals->totalBeforeTax }}</td>
        </tr>
        <tr>
            <td>{{ trans('vendirun::checkout.shipping') }}</td>
            <td class="js-shipping-before-tax">{{ $displayTotals->shippingBeforeTax }}</td>
        </tr>
        @if ($cart->tax() > 0)
            <tr>
                <td>{{ trans('vendirun::checkout.tax') }}</td>
                <td class="js-tax">{{ $displayTotals->tax }}</td>
            </tr>
        @endif
        <tr>
            <th>{{ trans('vendirun::checkout.total') }}</th>
            <th class="js-total">{{ $displayTotals->total }}</th>
        </tr>
    </table>
</div>