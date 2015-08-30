<div class="property-result clearfix">
    <div class="left">
        <div class="image-container">
            <ul class="{{ count($property->images) > 1 ? 'property-slide-show' : 'property-single-image' }}">
                @foreach ($property->images as $image)
                    <li><img src="{{ $image->mediumrect }}" class="img-responsive"></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="details">
        <div class="price">{{ $price }}</div>
        <h2>
            <a href="{{ route('vendirun.propertyView',[$property->id, urlencode($property->title)]) }}">{{ $property->title }}</a>
        </h2>
        {!! $property->short_description !!}
        <div class="amenities">
            @foreach ($property->attributes as $attribute)
                <label class="label label-primary" title="{{ $attribute->property_attribute_description }}">{{ $attribute->property_attribute_name }}</label>
            @endforeach
        </div>
    </div>
    @include('vendirun::property.partials.property-attributes')
    <div class="buttons">
        <a href="{{ route('vendirun.propertyView',[$property->id, $propertySlug]) }}" class="btn btn-default"><i class="fa fa-info"></i> Full Details</a>
        @if (isset($favouritePropertiesArray) && is_array($favouritePropertiesArray) && in_array($property->id, $favouritePropertiesArray))
            <a href="{{ route('vendirun.propertyRemoveFav', $property->id) }}" class="btn btn-default"><i class="fa fa-remove"></i> Remove From Favourites</a>
        @else
            <a href="{{ (in_array($property->id, $favouritePropertiesArray)) ? route('vendirun.viewFavouriteProperties') : route('vendirun.propertyAddToFav',$property->id) }}" class="btn btn-default">
                <i class="fa {{ in_array($property->id, $favouritePropertiesArray) ? 'fa-search' : 'fa-star' }}"></i>{{ in_array($property->id, $favouritePropertiesArray) ?  ' View Favourites' : ' Add to Favorites' }}
            </a>
        @endif

        <button type="button" data-property-name="{{ $property->title }}" data-property-id="{{ $property->id }}" class="btn btn-default js-send-to-friend">
            <i class="fa fa-user"></i> Send to a Friend
        </button>
        <a href="{{ route('vendirun.propertyView',[$property->id, urlencode($property->title)]) }}/#contact-us" class="btn btn-default">
            <i class="fa fa-envelope"></i> Contact Us
        </a>
    </div>
</div>