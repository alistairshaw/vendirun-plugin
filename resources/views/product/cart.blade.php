@extends('vendirun::layouts.standard')
@section('title', 'Shopping Cart')
@section('description', 'Checkout')
@section('keywords', '')
@section('body-class', 'product-cart')
@section('content')
    <div class="container">
        <h1>Shopping Cart</h1>
        <div class="wrapper">
            <div class="cart-items">
                @include('vendirun::product.partials.cart.cart-list')
            </div>
            <div class="cart-sidebar">
                @include('vendirun::product.partials.cart.checkout-button')
                @include('vendirun::product.partials.cart.options')
            </div>
        </div>
    </div>
@stop