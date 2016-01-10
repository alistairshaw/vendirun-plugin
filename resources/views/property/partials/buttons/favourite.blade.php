@if (in_array($property->id, $favouritePropertiesArray))
    <a href="{{ route('vendirun.propertyRemoveFav', $property->id) }}" class="btn btn-default btn-favourite" data-toggle="tooltip" title="{{ trans('vendirun::property.removeFromFavourites') }}">
        <i class="fa fa-remove"></i>{{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::property.removeFromFavourites') }}
    </a>
@else
    <a href="{{ (in_array($property->id, $favouritePropertiesArray)) ? route('vendirun.viewFavouriteProperties') : route('vendirun.propertyAddToFav', $property->id) }}" class="btn btn-default" data-toggle="tooltip" title="{{ in_array($property->id, $favouritePropertiesArray) ?  trans('vendirun::property.viewFavourites') : trans('vendirun::property.addToFavourites') }}">
        <i class="fa {{ in_array($property->id, $favouritePropertiesArray) ? 'fa-search' : 'fa-star text-warning' }}"></i>{{ in_array($property->id, $favouritePropertiesArray) ?  ($abbreviatedButtons ? '' : ' ' . trans('vendirun::property.viewFavourites')) : ($abbreviatedButtons ? '' : ' ' . trans('vendirun::property.addToFavourites')) }}
    </a>
@endif