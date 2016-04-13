@extends('vendirun::layouts.standard')
@section('title', 'Checkout')
@section('description', 'Checkout of your Shopping Cart')
@section('keywords', '')
@section('body-class', 'checkout')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::checkout.checkout') }}</h1>
        <div class="wrapper">
            <div class="checkout-form">
                @if (isset($paymentError))
                    <div class="alert alert-danger">{{ $paymentError }}</div>
                @endif
                @include('vendirun::checkout.partials.checkout-form')
            </div>
            <div class="checkout-sidebar">
                @include('vendirun::checkout.partials.checkout-cart')
            </div>
        </div>
    </div>
@stop