@extends('vendirun::layouts.standard')
@section('title', 'Products')
@section('description', 'Browse Products')
@section('keywords', '')
@section('body-class', 'vendirun-app product-search')
@section('content')
    <div class="container product-search">
        <div class="row">
            <div class="col-md-3 col-sm-4 hidden-xs hidden-sm">
                <div class="search-form">
                    @include('vendirun::product.refine.form')
                </div>
            </div>
            <div class="col-md-9 col-md-8">
                @include('vendirun::product.list')
            </div>
        </div>
    </div>
@stop