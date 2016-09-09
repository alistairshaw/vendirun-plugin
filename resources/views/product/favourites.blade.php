@extends('vendirun::layouts.standard')
@section('title', $pageTitle)
@section('description', 'Browse Products')
@section('keywords', '')
@section('body-class', 'vendirun-app product-search')
@section('content')
    <div class="container product-search">
        <h1>Wishlist</h1>
        @include('vendirun::product.list')
    </div>
@stop