<div class="property-related">
    @foreach ($property->related as $related)
        @include('vendirun::property.result', ['property' => $related, 'limitImages' => 1, 'includeButtons' => false])
    @endforeach
</div>