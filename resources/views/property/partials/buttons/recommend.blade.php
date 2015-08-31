<a href="{{ route('vendirun.propertyRecommend', ['propertyId' => $property->id]) }}" data-property-name="{{ $property->title }}" data-property-id="{{ $property->id }}" class="btn btn-default btn-recommend js-send-to-friend" data-toggle="tooltip" title="Send to a Friend">
    <i class="fa fa-user"></i> {{ $abbreviatedButtons ? '' : ' Send to a Friend' }}
</a>