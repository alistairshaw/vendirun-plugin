@if (count($productSearchResult->getAvailableSizes()) > 0)
    <h3>{{ trans('vendirun::product.sizes') }}</h3>
    <ul class="refine-list sizes-list">
        @foreach ($productSearchResult->getAvailableSizes() as $size)
            @if ($size->getName() == $productSearchResult->getSearchParam('size'))
                <li class="selected">
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $productSearchResult->getSearchParam('category'), 'size' => ''])) }}" data-toggle="tooltip" title="Select Size">{{ $size->getName() }}</a>
                </li>
            @else
                <li>
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $productSearchResult->getSearchParam('category'), 'size' => $size->getName()])) }}" data-toggle="tooltip" title="Select Size">{{ $size->getName() }}</a>
                </li>
            @endif
        @endforeach
    </ul>
@endif