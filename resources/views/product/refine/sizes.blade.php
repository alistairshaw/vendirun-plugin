@if (count($sizes) > 0)
    <h3>{{ trans('vendirun::product.sizes') }}</h3>
    <ul class="refine-list sizes-list">
        @foreach ($sizes as $size)
            @if ($size->name == $selectedSize)
                <li class="selected">
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $category, 'size' => ''])) }}" data-toggle="tooltip" title="Select Size">{{ $size->name }}</a>
                </li>
            @else
                <li>
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $category, 'size' => $size->name])) }}" data-toggle="tooltip" title="Select Size">{{ $size->name }}</a>
                </li>
            @endif
        @endforeach
    </ul>
@endif