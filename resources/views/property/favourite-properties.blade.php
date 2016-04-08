@extends('vendirun::layouts.standard')
@section('title', 'My Favourite Properties')
@section('description', '')
@section('keywords', '')
@section('body-class', 'property-search favourite-properties')
@section('content')
    <div class="container property-search type1 clearfix">
        <div class="property-results">
            <h2 class="page-header">{{ trans('vendirun::property.favourites') }}</h2>

            <div class="js-main-results multiple">
                @forelse ($properties as $item)
                    @include('vendirun::property.result', array('property'=>$item, 'limitImages' => 1, 'abbreviatedButtons' => true))
                @empty
                    <div class="large-notice">
                        <p>{{ trans('vendirun::property.noFavourites') }} <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.propertySearch') }}">{{ trans('vendirun::property.clickToFind') }}</a></p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@stop