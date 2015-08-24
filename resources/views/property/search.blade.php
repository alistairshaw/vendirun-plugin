@extends('vendirun::layouts.standard')

@section('content')
    <div class="container property-search clearfix">
        <div class="row search-height">
            <div class="js-main-results">

                @include('vendirun::forms.recommend-a-friend')

                <div class="property-results">

                    <h2 class="page-header">Search Results</h2>

                    @if ($properties && count($properties->result) > 0)

                        <div class="clearfix">
                            @if ($pagination)
                                <div class="pull-left pagination-container">
                                    {!! $pagination->render() !!}
                                </div>
                            @endif

                            <div class="pull-right form-inline per-page">
                                <label for="limit">Per Page</label>
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
                            @include('vendirun::property.result', array('property'=>$property))
                        @endforeach

                        <div class="clearfix">
                            @if ($pagination)
                                <div class="pull-left pagination-container">
                                    {!! $pagination->render() !!}
                                </div>
                            @endif

                            <div class="pull-right form-inline per-page">
                                <label for="limit">Per Page</label>
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
                        <p>No properties matched your search, please give it another go!</p>
                        @include('vendirun::property.simple-search-form')
                    @endif
                </div>

            </div>
            <div class="popout hidden-sm hidden-xs">
                @include('vendirun::property.partials.filter-button)
            </div>
            <div class="col-sm-2 hide left-column hidden-sm hidden-xs">
                <div class="well refine-search">
                    @include('vendirun::property.search-form')
                </div>
            </div>
        </div>
    </div>

@stop