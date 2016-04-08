<div class="image-container">
    <ul class="{{ ((count($product->images) > 1) && (!isset($limitImages) || $limitImages > 1)) ? 'product-slide-show' : 'product-single-image' }}">
        @foreach (array_slice($product->images, 0, (isset($limitImages) ? $limitImages : 50)) as $image)
            <img src="{{ $image->mediumsq }}" class="img-responsive" data-thumb="{{ $image->thumbnailsq }}">
        @endforeach
    </ul>
</div>