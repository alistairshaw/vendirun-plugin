<div class="order-review">
    <table class="table">
        <tr>
            <th>SKU</th>
            <th>Product</th>
            <th class="text-center">Quantity</th>
            <th>Discount</th>
            <th>Total</th>
            <th>Tax Rate</th>
            <th>Amount</th>
        </tr>
        @foreach ($order->concatItems() as $productVariationId => $item)
            <tr>
                <td>{{ $item['productSku'] }}</td>
                <td>{{ $item['productName'] }}</td>
                <td class="text-center">{{ $item['quantity'] }}</td>
                <td>{{ CurrencyHelper::formatWithCurrency($item['discount'], false, '') }}</td>
                <td>{{ CurrencyHelper::formatWithCurrency($item['price'], false, '') }}</td>
                <td>{{ $item['taxRate'] }}%</td>
                <td>{{ CurrencyHelper::formatWithCurrency($item['price'] + TaxCalculator::totalPlusTax($item['price'] - $item['discount'], $item['taxRate']), false, '') }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="5">&nbsp;</th>
            <th>SubTotal</th>
            <th>{{ CurrencyHelper::formatWithCurrency($order->getTotalPrice(), false, '') }}</th>
        </tr>
        <tr>
            <th colspan="5">&nbsp;</th>
            <th>Total</th>
            <th>{{ CurrencyHelper::formatWithCurrency($order->getTotalPrice(), false, '') }}</th>
        </tr>
    </table>
</div>