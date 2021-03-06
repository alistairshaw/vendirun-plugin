@extends('vendirun::layouts.standard')
@section('title', $pageTitle)
@section('description', 'Checkout of your Shopping Cart')
@section('keywords', '')
@section('body-class', 'vendirun-app checkout')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::checkout.checkout') }}</h1>
        <div class="wrapper">
            <div class="checkout-form">
                @if (Session::has('paymentError'))
                    <div class="alert alert-danger">{{ Session::get('paymentError') }}</div>
                @endif
                @include('vendirun::checkout.partials.checkout-form')
            </div>
            <div class="checkout-sidebar">
                @include('vendirun::checkout.partials.checkout-cart')
            </div>
        </div>
    </div>
@stop