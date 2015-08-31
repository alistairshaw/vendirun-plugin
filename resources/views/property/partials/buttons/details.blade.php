<a href="{{ route('vendirun.propertyView',[$property->id, $propertySlug]) }}" class="btn btn-default btn-details" data-toggle="tooltip" title="Property Details">
    <i class="fa fa-info"></i>{{ $abbreviatedButtons ? '' : ' More Details' }}
</a>