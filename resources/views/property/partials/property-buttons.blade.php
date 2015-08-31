<div class="buttons">
    @foreach ($propertyButtons as $button)
        @include('vendirun::property.partials.buttons.' . $button)
    @endforeach
</div>