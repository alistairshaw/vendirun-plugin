@extends('vendirun::layouts.standard')
@section('title', 'Products')
@section('description', 'Browse Products')
@section('keywords', '')
@section('body-class', 'product-search')
@section('content')
    <div class="container product-search">
        <h1>Wishlist</h1>
        @include('vendirun::product.list')
    </div>
@stop