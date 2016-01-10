<div class="property-result">
    <div>
        <div class="part-one">
            <div class="image-container">
                <ul class="{{ ((count($property->images) > 1) && (isset($limitImages) && $limitImages > 1)) ? 'property-slide-show' : 'property-single-image' }}">
                    @foreach (array_slice($property->images, 0, (isset($limitImages) ? $limitImages : 5)) as $image)
                        <a class="image-link" href="{{ route('vendirun.propertyView',[$property->id, urlencode($property->title)]) }}"><img src="{{ $image->mediumrect }}" class="img-responsive" data-thumb="{{ $image->thumbnailsq }}"></a>
                    @endforeach
                </ul>
                @if ($property->sold_at)
                    <div class="property-badge {{ $property->property_type == 'For Sale' ? trans('vendirun::property.sold') : trans('vendirun::property.rented') }}"></div>
                @endif
            </div>
        </div>
        <div class="details">
            <div class="price">{{ $price }}</div>
            <h2>
                <a href="{{ route('vendirun.propertyView',[$property->id, urlencode($property->title)]) }}">{{ $property->title }}</a>
            </h2>

            <div class="location">
                <h3>{{ $property->location }}&nbsp;</h3>
                <h4>{{ $property->city }}&nbsp;</h4>
            </div>
            <div class="short-description">
                {!! $property->short_description !!}
            </div>
            <div class="amenities">
                @foreach ($property->attributes as $attribute)
                    <label class="label label-primary" title="{{ $attribute->property_attribute_description }}">{{ $attribute->property_attribute_name }}</label>
                @endforeach
            </div>
        </div>
        @include('vendirun::property.partials.property-attributes')
        @if (!isset($includeButtons) || $includeButtons)
            @include('vendirun::property.partials.property-buttons')
        @endif
    </div>
</div>