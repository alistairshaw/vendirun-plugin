<div class="property-attributes">
    <div class="row">
        @foreach ($attributes as $attribute => $value)
            <div class="item"><span>{{ $attribute }}</span>{!! $value !!}</div>
        @endforeach
    </div>
</div>

<div class="property-attributes">
    @foreach ($property->attributes as $attribute)
        <div class="label label-info"><?php echo $attribute->property_attribute_name ?></div>
    @endforeach
</div>