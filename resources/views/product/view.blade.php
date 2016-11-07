@extends('vendirun::layouts.standard')
@section('title', strip_tags($productDisplay['productName']))
@section('description', strip_tags($productDisplay['shortDescription']))
@section('keywords', strip_tags($productDisplay['keywords']))
@section('body-class', 'vendirun-app product product-view js-product-view')
@section('content')
    <input type="hidden" id="productId" value="{{ $productDisplay['id'] }}">
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
                <h1>{{ $productDisplay['productName'] }}</h1>
                <form method="POST" action="{{ route(LocaleHelper::localePrefix() . 'vendirun.productAddToCartPost') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @include('vendirun::product.partials.product-variations')
                    @include('vendirun::product.partials.add-to-cart')
                    <div class="main-short-description">
                        {!! $productDisplay['shortDescription'] !!}
                    </div>
                    <div class="main-long-description">
                        {!! $productDisplay['longDescription'] !!}
                    </div>
                </form>

                @include('vendirun::forms.quick-enquiry')
            </div>
        </div>
    </div>
@stop
