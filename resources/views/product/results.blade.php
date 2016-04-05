@extends('vendirun::layouts.standard')
@section('title', 'Products')
@section('description', 'Browse Products')
@section('keywords', '')
@section('body-class', 'product-search')
@section('content')
    <div class="container product-search">
        <div class="row">
            <div class="col-md-3 col-sm-4 hidden-xs hidden-sm">
                <div class="search-form">
                    @include('vendirun::product.refine.form')
                </div>
            </div>
            <div class="col-md-9 col-md-8">
                <div class="heading">
                    <div class="form-inline">
                        <div class="form-group order-by">
                            <label for="order_by">{{ trans('vendirun::product.sort') }}</label>
                            <select class="form-control" name="order_by" id="order_by">
                                <option value="created_DESC"{{ ($productSearchParams['order_by'] == 'created') ? ' selected' : '' }}>{{ trans('vendirun::product.newest') }}</option>
                                <option value="price_ASC"{{ ($productSearchParams['order_by'] == 'price' && $productSearchParams['order_direction'] == 'ASC') ? ' selected' : '' }}>{{ trans('vendirun::product.priceLowestFirst') }}</option>
                                <option value="price_DESC"{{ ($productSearchParams['order_by'] == 'price' && $productSearchParams['order_direction'] == 'DESC') ? ' selected' : '' }}>{{ trans('vendirun::product.priceHighestFirst') }}</option>
                                <option value="sku_ASC"{{ ($productSearchParams['order_by'] == 'sku') ? ' selected' : '' }}>{{ trans('vendirun::product.sku') }}</option>
                            </select>
                        </div>

                        <div class="form-group per-page">
                            <label for="limit">{{ trans('vendirun::product.perPage') }}</label>
                            <select class="form-control" name="limit" id="limit">
                                <option value="6"{{ ($productSearchParams['limit'] == 6) ? ' selected' : '' }}>6</option>
                                <option value="12"{{ ($productSearchParams['limit'] == 12) ? ' selected' : '' }}>12</option>
                                <option value="18"{{ ($productSearchParams['limit'] == 18) ? ' selected' : '' }}>18</option>
                                <option value="24"{{ ($productSearchParams['limit'] == 24) ? ' selected' : '' }}>24</option>
                                <option value="30"{{ ($productSearchParams['limit'] == 30) ? ' selected' : '' }}>30</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="js-product-results multiple">
                    <div class="row">
                        @foreach ($products->result as $product)
                            @include('vendirun::product.result', ['product' => $product, 'limitImages' => 1, 'abbreviatedButtons' => true])
                        @endforeach
                    </div>
                </div>
                @if ($pagination)
                    <div class="pagination-container">
                        {!! $pagination->render() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop