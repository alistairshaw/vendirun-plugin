@extends('vendirun::layouts.standard')
@section('title', $pageTitle)
@section('description', 'Order process failed to complete')
@section('keywords', '')
@section('body-class', 'vendirun-app checkout')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::checkout.orderFailed') }}</h1>
        <p>{{ trans('vendirun::checkout.orderFailedText') }}</p>
        @if ($order)
            @include ('vendirun::customer.orders.partials.order-review')
        @endif
    </div>
@stop