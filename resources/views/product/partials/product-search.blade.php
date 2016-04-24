<form method="GET" action="{{ route(LocaleHelper::localePrefix() . 'vendirun.productSearch', array_merge(['category' => $productSearchResult->getSearchParam('category')], Request::query())) }}" class="product-simple-search-form">
    @foreach (Request::query() as $key => $value)
        @if ($key !== 'searchString')
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
    <input type="text" name="searchString" placeholder="Search" value="{{ Request::query('searchString', '') }}">
</form>