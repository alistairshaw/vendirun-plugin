@extends('vendirun::layouts.customer-account')
@section('title', $pageTitle)
@section('description', trans('vendirun::product.orderHistory'))
@section('keywords', '')
@section('body-class', 'vendirun-app product-orders')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::product.orderHistory') }}</h1>
        @if ($pagination && $pagination->hasPages())
            <div class="pagination-container">
                {!! $pagination->render() !!}
            </div>
        @endif
        @forelse ($orders as $order)
            @include('vendirun::customer.orders.partials.order-item')
        @empty
            @include('vendirun::customer.orders.partials.no-orders')
        @endforelse
        @if ($pagination && $pagination->hasPages())
            <div class="pagination-container">
                {!! $pagination->render() !!}
            </div>
        @endif
    </div>
@stop