<form method="GET" action="{{ route(LocaleHelper::localePrefix() . 'vendirun.productSearch', array_merge(['category' => ltrim($productSearchResult->getSearchParam('category'), '/')], Request::query())) }}" class="product-simple-search-form">
    @foreach (Request::query() as $key => $value)
        @if ($key !== 'searchString' && $key !== 'page')
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach
    <input type="hidden" name="page" value="1">
    <input type="text" name="searchString" placeholder="Search" value="{{ Request::query('searchString', '') }}">
</form>