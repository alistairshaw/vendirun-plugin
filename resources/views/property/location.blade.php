@extends('vendirun::layouts.standard')
@section('title', $location->location_name)
@section('description', $location->location_description)
@section('keywords', 'Property in ' . $location->location_name)
@section('body-class', 'cms-location')
@section('content')
    <div class="container clearfix">
        @include('vendirun::cms.widgets.property-locations')
    </div>
@stop