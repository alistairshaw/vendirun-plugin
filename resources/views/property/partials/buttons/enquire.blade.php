<a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.propertyView',[$property->id, urlencode($property->title)]) }}/#contact-us" class="btn btn-default btn-enquire" data-toggle="tooltip" title="{{ trans('vendirun::property.enquire') }}">
    <i class="fa fa-envelope"></i> {{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::property.enquire') }}
</a>