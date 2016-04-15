@if (in_array($product->id, $favouriteProductsArray))
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productRemoveFavourite', $product->id) }}" class="btn btn-default btn-favourite" data-toggle="tooltip" title="{{ trans('vendirun::product.removeFromFavourites') }}">
        <i class="fa fa-star"></i>{{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::product.removeFromFavourites') }}
    </a>
@else
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productAddFavourite', $product->id) }}" class="btn btn-default btn-add-to-favourites" data-toggle="tooltip" title="{{ trans('vendirun::product.addToFavourites') }}">
        <i class="fa fa-star"></i>{{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::product.addToFavourites') }}
    </a>
@endif