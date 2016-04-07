@if (count($colors) > 0)
    <h3>{{ trans('vendirun::product.colors') }}</h3>
    <ul class="refine-list color-list">
        @foreach ($colors as $color)
            @if ($color->name == $selectedColor)
                <li class="selected">
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $category, 'color' => ''])) }}" style="background-color: {{ $color->hex }};" data-toggle="tooltip" title="{{ $color->name }}">
                        <i class="fa fa-check"></i>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $category, 'color' => $color->name])) }}" style="background-color: {{ $color->hex }};" data-toggle="tooltip" title="{{ $color->name }}"></a>
                </li>
            @endif
        @endforeach
    </ul>
@endif