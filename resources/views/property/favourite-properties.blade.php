@extends('vendirun::layouts.standard')
@section('title', 'My Favourite Properties')
@section('description', '')
@section('keywords', '')
@section('body-class', 'property-search favourite-properties')
@section('content')
    <div class="container property-search type1 clearfix">
        <div class="property-results">
            <h2 class="page-header">Favourited Properties</h2>

            <div class="js-main-results multiple">
                @forelse ($properties as $item)
                    @include('vendirun::property.result', array('property'=>$item, 'limitImages' => 1, 'abbreviatedButtons' => true))
                @empty
                    <p>You don't have any favourite properties yet! Click <a href="{{ route('vendirun.propertySearch') }}">here</a> to explore and find some!.</p>
                @endforelse
            </div>
        </div>
    </div>
@stop