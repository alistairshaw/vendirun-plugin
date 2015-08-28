<div class="property-attributes">
    <div class="row">
        @foreach ($attributes as $attribute => $value)
            <div class="item"><span>{{ $attribute }}</span>{{ $value }}</div>
        @endforeach
    </div>
</div>