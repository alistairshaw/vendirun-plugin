@if (count($types) > 0)
    <h3>{{ trans('vendirun::product.types') }}</h3>
    <ul class="refine-list types-list">
        @foreach ($types as $type)
            @if ($type->name == $selectedType)
                <li class="selected">
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $category, 'type' => ''])) }}" data-toggle="tooltip" title="Select Size">{{ $type->name }}</a>
                </li>
            @else
                <li>
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $category, 'type' => $type->name])) }}" data-toggle="tooltip" title="Select Size">{{ $type->name }}</a>
                </li>
            @endif
        @endforeach
    </ul>
@endif