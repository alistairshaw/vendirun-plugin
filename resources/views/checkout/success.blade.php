@extends('vendirun::layouts.standard')
@section('title', 'Order Confirmation')
@section('description', 'Confirmation of your Order')
@section('keywords', '')
@section('body-class', 'vendirun-app checkout')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::checkout.orderComplete') }}</h1>
        <p>{{ trans('vendirun::checkout.thanksForOrder') }}</p>
        @if ($order)
            @include ('vendirun::customer.orders.partials.order-review')
        @endif
    </div>
@stop