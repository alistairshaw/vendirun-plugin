<a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.propertyView',[$property->id, $propertySlug]) }}" class="btn btn-default btn-details" data-toggle="tooltip" title="{{ trans('vendirun::property.propertyDetails') }}">
    <i class="fa fa-info"></i>{{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::property.moreDetails') }}
</a>