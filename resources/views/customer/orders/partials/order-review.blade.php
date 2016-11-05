<div class="table-responsive order-review">
    <table class="table">
        <tr>
            <th>{{ trans('vendirun::product.sku') }}</th>
            <th>{{ trans('vendirun::product.productName') }}</th>
            <th class="text-center">{{ trans('vendirun::product.quantity') }}</th>
            <th>{{ trans('vendirun::product.discount') }}</th>
            <th>{{ trans('vendirun::checkout.subTotal') }}</th>
            <th>{{ trans('vendirun::checkout.tax') }}</th>
            <th>{{ trans('vendirun::product.total') }}</th>
        </tr>
        @foreach ($order->getItems() as $item)
            <tr>
                <td>{{ $item->getProductSku() }}</td>
                <td>{{ $item->getProductName() }}</td>
                <td class="text-center">{{ $item->getQuantity() }}</td>
                <td>{{ CurrencyHelper::formatWithCurrency($item->getDiscount(), false, '') }}</td>
                <td>{{ CurrencyHelper::formatWithCurrency($item->getPrice(), false, '') }}</td>
                <td>{{ $item->getTaxRate() }}%</td>
                <td>{{ CurrencyHelper::formatWithCurrency($item->getPrice() + TaxCalculator::totalPlusTax($item->getPrice() - $item->getdiscount(), $item->getTaxRate()), false, '') }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="7">&nbsp;</th>
        </tr>
        <tr>
            <th colspan="5">&nbsp;</th>
            <th>{{ trans('vendirun::checkout.subTotal') }}</th>
            <th>{{ CurrencyHelper::formatWithCurrency($order->getPriceBeforeTax(), false, '') }}</th>
        </tr>
        <tr>
            <th colspan="5">&nbsp;</th>
            <th>{{ trans('vendirun::checkout.tax') }}</th>
            <th>{{ CurrencyHelper::formatWithCurrency($order->getTax(), false, '') }}</th>
        </tr>
        <tr>
            <th colspan="5">&nbsp;</th>
            <th>{{ trans('vendirun::checkout.total') }}</th>
            <th>{{ CurrencyHelper::formatWithCurrency($order->getTotalPrice(), false, '') }}</th>
        </tr>
    </table>
</div>