@extends('vendirun::layouts.standard')
@section('title', $property->title)
@section('description', strip_tags($property->short_description))
@section('keywords', $property->keywords)
@section('body-class', 'cms-property cms-property-ref-' . strtolower(str_replace('/', '-', $property->reference)))
@section('content')
    <div class="container property-view type1 js-single-property">
        <div class="row">
            <div class="col-sm-9">
                <div class="heading">
                    <p class="price">
                        <strong>{{ $price }}</strong><br>
                        {{ $property->reference }}
                    </p>
                    <h1>{{ $property->title }}</h1>
                    <h2>{{ $property->location }}, {{ $property->city }}</h2>
                </div>

                <div class="image-container">
                    <ul class="{{ (count($property->images) > 1) ? 'property-slide-show' : 'property-single-image' }}">
                        @foreach ($property->images as $image)
                            <img src="{{ $image->mediumrect }}" class="img-responsive" data-thumb="{{ $image->thumbnailsq }}">
                        @endforeach
                    </ul>
                    @if ($property->sold_at)
                        <div class="property-badge {{ $property->property_type == 'For Sale' ? 'sold' : 'rented' }}"></div>
                    @endif
                </div>

                @include('vendirun::property.partials.property-attributes')

                <div class="description">
                    <h3>{{ trans('vendirun::property.description') }}</h3>
                    {!! $property->long_description !!}
                </div>

                @include('vendirun::forms.quick-enquiry')
            </div>

            <div class="col-sm-3">
                <div class="sidebar">
                    <h3>{{ trans('vendirun::property.likeThis') }}</h3>
                    @include('vendirun::property.partials.property-buttons', ['propertyButtons' => ['enquire', 'recommend', 'property-card', 'favourite']])

                    <h3>{{ trans('vendirun::standard.share') }}</h3>
                    @include('vendirun::cms.widgets.social-share')

                    <h3>{{ trans('vendirun::property.relatedProperties') }}</h3>
                    @include('vendirun::property.partials.related-property')
                </div>
            </div>
        </div>
    </div>
@stop