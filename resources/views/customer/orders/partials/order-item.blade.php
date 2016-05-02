<div class="order-item">
    <div class="section1">
        <div class="order-placed">
            {{ trans('vendirun::product.orderPlaced') }}<br>
            <span>{{ date(Config::get('vendirun.dateFormat', 'jS, M Y'), strtotime($order->getCreatedDate())) }}</span>
        </div>
        <div class="order-total">
            {{ trans('vendirun::product.total') }}<br>
            <span>{{ CurrencyHelper::formatWithCurrency($order->getTotalPrice(), false, '') }}</span>
        </div>
        <div class="status">
            {{ trans('vendirun::product.orderStatus') }}<br>
            <span>{{ $order->getStatus() }}</span>
        </div>
        <div class="options">
            <div class="order-id">
                {{ trans('vendirun::product.orderId') }}:
                <span>{{ $order->getId() }}</span>
            </div>
            <ul class="links">
                <li>
                    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.account.orderView', ['orderId' => $order->getId()]) }}">{{ trans('vendirun::product.viewOrder') }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="section2">
        <ul class="product-list">
            @foreach ($order->getItems() as $orderItem)
                @if (!$orderItem->isShipping())
                    <li><span>{{ $orderItem->getProductSku() }}</span> {{ $orderItem->getProductName() }}</li>
                @endif
            @endforeach
        </ul>
    </div>
</div>