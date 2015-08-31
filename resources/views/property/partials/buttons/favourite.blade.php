@if (in_array($property->id, $favouritePropertiesArray))
    <a href="{{ route('vendirun.propertyRemoveFav', $property->id) }}" class="btn btn-default btn-favourite" data-toggle="tooltip" title="Remove from Favourites">
        <i class="fa fa-remove"></i>{{ $abbreviatedButtons ? '' : ' Remove from Favourites' }}
    </a>
@else
    <a href="{{ (in_array($property->id, $favouritePropertiesArray)) ? route('vendirun.viewFavouriteProperties') : route('vendirun.propertyAddToFav', $property->id) }}" class="btn btn-default" data-toggle="tooltip" title="{{ in_array($property->id, $favouritePropertiesArray) ?  ' View Favourites' : ' Add to Favorites' }}">
        <i class="fa {{ in_array($property->id, $favouritePropertiesArray) ? 'fa-search' : 'fa-star text-warning' }}"></i>{{ in_array($property->id, $favouritePropertiesArray) ?  ($abbreviatedButtons ? '' : ' View Favourites') : ($abbreviatedButtons ? '' : ' Add to Favourites') }}
    </a>
@endif