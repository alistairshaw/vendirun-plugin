<form method="get">
    <div class="heading">
        <div class="form-inline">
            <div class="form-group order-by">
                <label for="order_by">{{ trans('vendirun::product.sort') }}</label>
                <select class="form-control" name="order_by" id="order_by">
                    <option value="created_DESC"{{ ($productSearchResult->getSearchParam('order_by') == 'created') ? ' selected' : '' }}>{{ trans('vendirun::product.newest') }}</option>
                    <option value="price_ASC"{{ ($productSearchResult->getSearchParam('order_by') == 'price' && $productSearchResult->getSearchParam('order_direction') == 'ASC') ? ' selected' : '' }}>{{ trans('vendirun::product.priceLowestFirst') }}</option>
                    <option value="price_DESC"{{ ($productSearchResult->getSearchParam('order_by') == 'price' && $productSearchResult->getSearchParam('order_direction') == 'DESC') ? ' selected' : '' }}>{{ trans('vendirun::product.priceHighestFirst') }}</option>
                    <option value="sku_ASC"{{ ($productSearchResult->getSearchParam('order_by') == 'sku') ? ' selected' : '' }}>{{ trans('vendirun::product.sku') }}</option>
                </select>
            </div>

            <div class="form-group per-page">
                <label for="limit">{{ trans('vendirun::product.perPage') }}</label>
                <select class="form-control" name="limit" id="limit">
                    <option value="6"{{ ($productSearchResult->getSearchParam('limit') == 6) ? ' selected' : '' }}>6</option>
                    <option value="12"{{ ($productSearchResult->getSearchParam('limit') == 12) ? ' selected' : '' }}>12</option>
                    <option value="18"{{ ($productSearchResult->getSearchParam('limit') == 18) ? ' selected' : '' }}>18</option>
                    <option value="24"{{ ($productSearchResult->getSearchParam('limit') == 24) ? ' selected' : '' }}>24</option>
                    <option value="30"{{ ($productSearchResult->getSearchParam('limit') == 30) ? ' selected' : '' }}>30</option>
                </select>
                <button type="submit" class="btn btn-default"><i class="fa fa-refresh"></i> Reload</button>
            </div>
        </div>
    </div>
    <div class="product-results multiple">
        <div class="row">
            @foreach ($productSearchResult->getProducts() as $product)
                @include('vendirun::product.result', ['product' => $product, 'limitImages' => 1, 'abbreviatedButtons' => true])
            @endforeach
        </div>
    </div>
    @if ($pagination)
        <div class="pagination-container">
            {!! $pagination->render() !!}
        </div>
    @endif
</form>