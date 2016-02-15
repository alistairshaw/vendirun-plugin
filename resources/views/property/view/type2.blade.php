@extends('vendirun::layouts.standard')
@section('title', $property->title)
@section('description', $property->short_description)
@section('keywords', $property->keywords)
@section('body-class', 'cms-property cms-property-ref-' . strtolower(str_replace('/', '-', $property->reference)))
@section('content')

    <div class="container property-view type2 js-single-property">
        <div class="image-container">
            <ul class="property-single-image">
                <a class="image-link" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertyView',[$property->id, urlencode($property->title)]) }}"><img src="{{ $property->images[0]->largerect }}" class="img-responsive"></a>
            </ul>
            @if ($property->sold_at)
                <div class="property-badge {{ $property->property_type == 'For Sale' ? 'sold' : 'rented' }}"></div>
            @endif
        </div>

        <div class="well description-well">
            <div class="price">{{ $price }}</div>
            <h1>{{ $property->title }}</h1>
            {!! $property->short_description !!}
            <p><strong>Reference {!! $property->reference !!}</strong></p>
        </div>

        <div class="image-container thumbnails">
            <div class="row">
                @foreach($property->images as $images)
                    <div class="col-sm-3">
                        <a href="{{ $images->large }}" data-lightbox="image-1" data-title="Images"><img src="{{ $images->mediumsq }}" class="img-responsive img-thumbnail"></a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="well amenities-well">
            <div class="amenities">
                @foreach($property->attributes as $row)
                    <label class="label label-primary">{{ $row->property_attribute_name }}</label>
                @endforeach
            </div>
        </div>

        <div class="well">
            @include('vendirun::property.partials.property-buttons', ['propertyButtons' => ['enquire', 'favourite', 'property-card', 'recommend']])
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="well description-well">
                    {!! $property->long_description !!}
                    @include('vendirun::property.partials.property-attributes')
                </div>
            </div>
        </div>

        @if($property->lat && $property->lng)
            <input type="hidden" id="propertyLat" value="{{ $property->lat }}">
            <input type="hidden" id="propertyLng" value="{{ $property->lng }}">
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
            <div class="well">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="map-canvas"></div>
                    </div>
                </div>
            </div>
        @endif

        @include('vendirun::forms.quick-enquiry')
    </div>
    @include('vendirun::forms.recommend-a-friend', ['hideRacForm' => true])

@stop