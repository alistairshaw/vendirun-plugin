@if (count($productSearchResult->getAvailableColors()) > 0)
    <h3>{{ trans('vendirun::product.colors') }}</h3>
    <ul class="refine-list color-list">
        @foreach ($productSearchResult->getAvailableColors() as $color)
            @if ($color->getName() == $productSearchResult->getSearchParam('color'))
                <li class="selected">
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $productSearchResult->getSearchParam('category'), 'color' => ''])) }}" style="background-color: {{ $color->getHex() }};" data-toggle="tooltip" title="{{ $color->getName() }}">
                        <i class="fa fa-check"></i>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ URL::route('vendirun.productSearch', array_merge(Request::query(), ['category' => $productSearchResult->getSearchParam('category'), 'color' => $color->getName()])) }}" style="background-color: {{ $color->getHex() }};" data-toggle="tooltip" title="{{ $color->getName() }}"></a>
                </li>
            @endif
        @endforeach
    </ul>
@endif