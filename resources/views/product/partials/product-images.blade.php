<div class="image-container">
    <ul class="{{ ((count($productDisplay['images']) > 1) && (!isset($limitImages) || $limitImages > 1)) ? 'product-slide-show js-product-slide-show' : 'product-single-image' }}">
        @foreach (array_slice($productDisplay['images'], 0, (isset($limitImages) ? $limitImages : 50)) as $image)
            <a href="{{ $viewProductRoute }}">
                <img src="{{ $image->medium }}" class="img-responsive" data-thumb="{{ $image->thumbnail }}">
            </a>
        @endforeach
    </ul>
</div>