@if (count($productSearchResult->getAvailableTypes()) > 0)
    <h3>{{ trans('vendirun::product.types') }}</h3>
    <ul class="refine-list types-list">
        @foreach ($productSearchResult->getAvailableTypes() as $type)
            @if ($type->getName() == $productSearchResult->getSearchParam('type'))
                <li class="selected">
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $productSearchResult->getSearchParam('category'), 'type' => 'x'])) }}" data-toggle="tooltip" title="Select Size">{{ $type->getName() }}</a>
                </li>
            @else
                <li>
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $productSearchResult->getSearchParam('category'), 'type' => $type->getName()])) }}" data-toggle="tooltip" title="Select Size">{{ $type->getName() }}</a>
                </li>
            @endif
        @endforeach
    </ul>
@endif