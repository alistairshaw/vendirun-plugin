@extends('vendirun::layouts.standard')
@section('title', trans('vendirun::product.orderHistory'))
@section('description', trans('vendirun::product.orderHistory'))
@section('keywords', '')
@section('body-class', 'vendirun-app product-orders')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::product.orderHistory') }}</h1>
        @if ($pagination->hasPages())
            <div class="pagination-container">
                {!! $pagination->render() !!}
            </div>
        @endif
        @foreach ($orders as $order)
            @include('vendirun::customer.orders.partials.order-item')
        @endforeach
        @if ($pagination->hasPages())
            <div class="pagination-container">
                {!! $pagination->render() !!}
            </div>
        @endif
    </div>
@stop