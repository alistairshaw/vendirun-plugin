@extends('vendirun::layouts.standard')
@section('title', trans('vendirun::product.viewOrder'))
@section('description', trans('vendirun::product.viewOrder'))
@section('keywords', '')
@section('body-class', 'vendirun-app product-orders view-order')
@section('content')
    <div class="container">
        @if (Session::has('paymentError'))
            <div class="alert alert-danger">{{ Session::get('paymentError') }}</div>
        @endif

        <h1>{{ trans('vendirun::product.viewOrder') }}</h1>
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
                        </li>
                        {{--<a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.account.orderView', ['orderId' => $order->getId()]) }}">{{ trans('vendirun::product.viewOrder') }}</a>--}}
                    </ul>
                </div>
            </div>
        </div>

        <h2>{{ trans('vendirun::orders.orderDetails') }}</h2>
        <div class="order-details">
            <div class="wrapper">
                <div class="shipping">
                    <h3>{{ trans('vendirun::checkout.shippingAddress') }}</h3>
                    @foreach ($order->getShippingAddress()->getArray() as $key => $item)
                        {!! $item && $key !== 'countryId' ? $item . '<br>' : '' !!}
                    @endforeach
                </div>
                <div class="list">
                    @include ('vendirun::customer.orders.partials.order-review')
                </div>
            </div>
        </div>

        <h2>{{ trans('vendirun::orders.paymentDetails') }}</h2>
        @if (count($order->getPayments()) == 0)
            @include ('vendirun::customer.orders.partials.payment-pending')
        @else
            @include ('vendirun::customer.orders.partials.payments', ['payments' => $order->getPayments()])
        @endif

        <h2>{{ trans('vendirun::orders.shipmentDetails') }}</h2>
            @if (count($order->getShipments()) == 0)
                @include ('vendirun::customer.orders.partials.shipment-pending')
            @else
                @include ('vendirun::customer.orders.partials.shipments', ['shipments' => $order->getShipments()])
            @endif
    </div>
@stop