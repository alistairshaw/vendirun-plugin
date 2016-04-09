<div class="image-container">
    <ul class="{{ ((count($product->images) > 1) && (!isset($limitImages) || $limitImages > 1)) ? 'product-slide-show' : 'product-single-image' }}">
        @foreach (array_slice($product->images, 0, (isset($limitImages) ? $limitImages : 50)) as $image)
            <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productView', ['productId' => $product->id, 'productName' => urlencode(strtolower($product->product_name))]) }}">
                <img src="{{ $image->mediumsq }}" class="img-responsive" data-thumb="{{ $image->thumbnailsq }}">
            </a>
        @endforeach
    </ul>
</div>