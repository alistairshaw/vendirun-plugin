@extends('vendirun::layouts.standard')
@section('title', 'Property Search')
@section('description', 'Search for properties')
@section('keywords', '')
@section('body-class', 'property-search')
@section('content')
    <div class="container property-search type1">
        <div class="row">
            <div class="col-md-3 col-sm-4 hidden-xs hidden-sm">
                <div class="search-form">
                    <h3>{{ trans('vendirun::property.refineSearch') }}</h3>
                    @include('vendirun::property.search-form')
                </div>
            </div>
            <div class="col-md-9 col-md-8">
                <div class="heading">
                    <div class="form-inline">
                        <div class="form-group order-by">
                            <label for="order_by">{{ trans('vendirun::property.sort') }}</label>
                            <select class="form-control" name="order_by" id="order_by">
                                <option value="created_DESC"{{ ($searchParams['order_by'] == 'created') ? ' selected' : '' }}>{{ trans('vendirun::property.newest') }}</option>
                                <option value="price_ASC"{{ ($searchParams['order_by'] == 'price' && $searchParams['order_direction'] == 'ASC') ? ' selected' : '' }}>{{ trans('vendirun::property.priceLowestFirst') }}</option>
                                <option value="price_DESC"{{ ($searchParams['order_by'] == 'price' && $searchParams['order_direction'] == 'DESC') ? ' selected' : '' }}>{{ trans('vendirun::property.priceHighestFirst') }}</option>
                                <option value="reference_ASC"{{ ($searchParams['order_by'] == 'reference') ? ' selected' : '' }}>{{ trans('vendirun::property.reference') }}</option>
                            </select>
                        </div>

                        <div class="form-group per-page">
                            <label for="limit">{{ trans('vendirun::property.perPage') }}</label>
                            <select class="form-control" name="limit" id="limit">
                                <option value="6"{{ ($searchParams['limit'] == 6) ? ' selected' : '' }}>6</option>
                                <option value="12"{{ ($searchParams['limit'] == 12) ? ' selected' : '' }}>12</option>
                                <option value="18"{{ ($searchParams['limit'] == 18) ? ' selected' : '' }}>18</option>
                                <option value="24"{{ ($searchParams['limit'] == 24) ? ' selected' : '' }}>24</option>
                                <option value="30"{{ ($searchParams['limit'] == 30) ? ' selected' : '' }}>30</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="js-main-results multiple">
                    <div class="row">
                        @foreach ($properties->result as $property)
                            @include('vendirun::property.result', ['property' => $property, 'limitImages' => 1, 'abbreviatedButtons' => true])
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