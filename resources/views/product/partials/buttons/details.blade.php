<a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productView',[$product->id, urlencode($product->product_name)]) }}" class="btn btn-default btn-details" data-toggle="tooltip" title="{{ trans('vendirun::product.productDetails') }}">
    <i class="fa fa-info"></i>{{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::property.moreDetails') }}
</a>