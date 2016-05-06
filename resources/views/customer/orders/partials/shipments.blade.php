@foreach ($shipments as $shipment)
    <?php $view = $shipment->display() ?>
    <div class="shipment-details">
        <div class="wrapper">
            <div class="shipment-made">
                {{ trans('vendirun::orders.shippedDate') }}<br>
                <span>{{ $view['shippedDate'] }}</span>
            </div>
            @if ($view['shippingCompany'])
                <div class="shipping-company">
                    {{ trans('vendirun::orders.shippingCompany') }}<br>
                    <span>{{ $view['shippingCompany'] }}</span>
                </div>
            @endif
            @if ($view['deliveryWindowDate'])
                <div class="delivery-window">
                    {{ trans('vendirun::orders.expectedDelivery') }}<br>
                    <span>{{ $view['deliveryWindowDate'] }} {{ $view['deliveryWindowTime'] }}</span>
                </div>
            @endif
            @if ($view['trackingNumber'])
                <div class="tracking-number">
                    {{ trans('vendirun::orders.trackingNumber') }}<br>
                    <span>
                        {{ $view['trackingUrl'] ? '<a href="' . $view['trackingUrl'] . '" target="_blank">' : '' }}
                        {{ $view['trackingNumber'] }}
                        {{ $view['trackingUrl'] ? '</a>' : '' }}
                    </span>
                </div>
            @endif
            <div class="item-count">
                {{ trans('vendirun::orders.itemsInShipment') }}<br>
                <span>{{ $view['itemCount'] }}</span>
            </div>
        </div>
        <div class="shipment-contains">

        </div>
    </div>
@endforeach