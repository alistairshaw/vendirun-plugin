<h3>{{ trans('vendirun::product.colors') }}</h3>
<ul class="color-list">
    @foreach ($colors as $color)
        <li>
            <a href="{{ URL::route('vendirun.productSearch', ['category' => $category, 'color' => $color->name]) }}" style="background-color: {{ $color->hex }};" data-toggle="tooltip" title="{{ $color->name }}"></a>
        </li>
    @endforeach
</ul>