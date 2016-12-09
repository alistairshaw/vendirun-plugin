<div class="order-review">
    <table class="table">
        <tr>
            <td>{{ trans('vendirun::checkout.subTotal') }}</td>
            <td class="js-total-before-tax">{{ $displayTotals['displayTotal'] }}</td>
        </tr>
        @if ($cart->shippingApplies())
            <tr>
                <td>{{ trans('vendirun::checkout.shipping') }}</td>
                <td class="js-shipping-before-tax">{{ $displayTotals['displayShipping'] }}</td>
            </tr>
        @endif
        @if ($displayTotals['subTotal'] != $displayTotals['displayTotal'])
            <tr>
                <td>{{ trans('vendirun::checkout.tax') }}</td>
                <td class="js-tax">{{ $displayTotals['tax'] }}</td>
            </tr>
        @endif
        <tr>
            <th>{{ trans('vendirun::checkout.total') }}</th>
            <th class="js-total">{{ $displayTotals['total'] }}</th>
        </tr>
    </table>
</div>