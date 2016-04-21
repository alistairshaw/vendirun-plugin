@extends('vendirun::layouts.standard')
@section('title', strip_tags($product->product_name))
@section('description', strip_tags($product->short_description))
@section('keywords', strip_tags($product->keywords))
@section('body-class', 'vendirun-app product product-view')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="product-images">
                    @include('vendirun::product.partials.product-images')
                </div>
                <h3>{{ trans('vendirun::standard.shareThis') }}</h3>
                <div class="product-share">
                    @include ('vendirun::cms.widgets.social-share')
                </div>
                <h3>{{ trans('vendirun::product.relatedProducts') }}</h3>
                @include('vendirun::product.partials.related-products')
            </div>
            <div class="col-md-8">
                <h1>{{ $product->product_name }}</h1>
                <form method="POST" action="{{ route(LocaleHelper::localePrefix() . 'vendirun.productAddToCartPost') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @include('vendirun::product.partials.product-variations')
                    @include('vendirun::product.partials.add-to-cart')
                    <div class="main-short-description">
                        {!! $product->short_description !!}
                    </div>
                    <div class="main-long-description">
                        {!! $product->long_description !!}
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
