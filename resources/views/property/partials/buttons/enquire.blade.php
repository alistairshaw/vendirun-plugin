<a href="{{ route('vendirun.propertyView',[$property->id, urlencode($property->title)]) }}/#contact-us" class="btn btn-default btn-enquire" data-toggle="tooltip" title="Enquire">
    <i class="fa fa-envelope"></i> {{ $abbreviatedButtons ? '' : ' Enquire' }}
</a>