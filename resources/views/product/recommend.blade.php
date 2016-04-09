@extends('vendirun::layouts.standard')
@section('title', $product->product_name)
@section('description', $product->short_description)
@section('keywords', $product->keywords)
@section('body-class', 'cms-product-recommend js-static-raf')
@section('content')

    <div class="container">
        <h1>{{ trans('vendirun::product.sendProductToFriend') }}</h1>
        <div class="row">
            <div class="col-sm-8">
                @include('vendirun::forms.recommend-a-friend')
                <br><br>
            </div>
            <div class="col-sm-4 product-search type1">
                @include('vendirun::product.result', ['product' => $product, 'limitImages' => 1, 'abbreviatedButtons' => true])
            </div>
        </div>
    </div>

@stop