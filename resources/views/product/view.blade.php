@extends('vendirun::layouts.standard')
@section('title', $product->product_name)
@section('description', $product->short_description)
@section('keywords', $product->keywords)
@section('body-class', 'product product-view')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="product-images">
                    @include('vendirun::product.partials.product-images')
                </div>
            </div>
            <div class="col-md-9 col-md-8">
                <h1>{{ $product->product_name }}</h1>
            </div>
        </div>
    </div>
@stop
