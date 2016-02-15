@extends('vendirun::layouts.standard')
@section('title', 'Property Search')
@section('description', 'Search for properties')
@section('keywords', '')
@section('body-class', 'property-search')
@section('content')
    <div class="container property-search type2 clearfix">
        <div class="row search-height">
            <div class="js-main-results">

                @include('vendirun::forms.recommend-a-friend', ['hideRacForm' => true])

                <div class="property-results">

                    <h2 class="page-header">{{ trans('vendirun::property.searchResults') }}</h2>

                    @if ($properties && count($properties->result) > 0)

                        <div class="clearfix">
                            @if ($pagination)
                                <div class="pull-left pagination-container">
                                    {!! $pagination->render() !!}
                                </div>
                            @endif

                            <div class="pull-right form-inline per-page">
                                <label for="limit">{{ trans('vendirun::property.perPage') }}</label>
                                <select class="form-control" name="limit" id="limit">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>

                        @foreach ($properties->result as $property)
                            @include('vendirun::property.result', array('property' => $property, 'limitImages' => 10))
                        @endforeach

                        <div class="clearfix">
                            @if ($pagination)
                                <div class="pull-left pagination-container">
                                    {!! $pagination->render() !!}
                                </div>
                            @endif

                            <div class="pull-right form-inline per-page">
                                <label for="limit">{{ trans('vendirun::property.perPage') }}</label>
                                <select class="form-control" name="limit" id="limit">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    @else
                        <p>{{ trans('vendirun::property.noMatches') }}</p>
                        @include('vendirun::property.simple-search-form')
                    @endif
                </div>

            </div>
            <div class="popout hidden-sm hidden-xs">
                @include('vendirun::property.partials.filter-button')
            </div>
            <div class="col-sm-2 hide left-column hidden-sm hidden-xs">
                <div class="well refine-search">
                    <h3>{{ trans('vendirun::property.refineSearch') }}</h3>
                    @include('vendirun::property.search-form')
                </div>
            </div>
        </div>
    </div>

@stop