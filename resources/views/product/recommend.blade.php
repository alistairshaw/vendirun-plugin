@extends('vendirun::layouts.standard')
@section('title', $pageTitle)
@section('description', strip_tags($productDisplay['shortDescription']))
@section('keywords', strip_tags($productDisplay['keywords']))
@section('body-class', 'vendirun-app product product-view')
@section('content')

    <div class="container">
        <h1>{{ trans('vendirun::product.sendProductToFriend') }}</h1>
        <div class="row">
            <div class="col-sm-8">
                @include('vendirun::forms.recommend-a-friend')
                <br><br>
            </div>
            <div class="col-sm-4 product-search type1" style="margin-top: 20px;">
                @include('vendirun::product.result', ['product' => $product, 'limitImages' => 1, 'abbreviatedButtons' => true])
            </div>
        </div>
    </div>

@stop