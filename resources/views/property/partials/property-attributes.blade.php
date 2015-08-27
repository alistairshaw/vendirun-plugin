<div class="property-attributes">
    <div class="row">
        @if ($property->city)
            <div class="item"><span>Town:</span> {{ $property->city }}</div>
        @endif
        @if ($property->location_name)
            <div class="item"><span>Location:</span> {{ $property->location_name }}</div>
        @endif
        @if ($property->bedrooms)
            <div class="item"><span>Bedrooms:</span> {{ $property->bedrooms }}</div>
        @endif
        @if ($property->bathrooms)
            <div class="item"><span>Bathrooms:</span> {{ $property->bathrooms }}</div>
        @endif
        @if ($property->build_size)
            <div class="item"><span>Garden Size:</span> {{ $property->build_size }}m<sup>2</sup></div>
        @endif
        @if ($property->terrace_size)
            <div class="item"><span>Total Plot Size:</span> {{ $property->terrace_size }}m<sup>2</sup></div>
        @endif
        @if ($property->garden_size)
            <div class="item"><span>Garden Size:</span> {{ $property->garden_size }}m<sup>2</sup></div>
        @endif
        @if ($property->total_plot_size)
            <div class="item"><span>Total Plot Size:</span> {{ $property->total_plot_size }}m<sup>2</sup></div>
        @endif
        @if ($property->reference)
            <div class="item"><span>Reference:</span> {{ $property->reference }}</div>
        @endif
    </div>
</div>