<div class="product-result">
    <div>
        <div class="part-one">
            <div class="image-container">
                <ul class="{{ ((count($product->images) > 1) && (isset($limitImages) && $limitImages > 1)) ? 'product-slide-show' : 'product-single-image' }}">
                    @foreach (array_slice($product->images, 0, (isset($limitImages) ? $limitImages : 5)) as $image)
                        <img src="{{ $image->mediumrect }}" class="img-responsive" data-thumb="{{ $image->thumbnailsq }}">
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="details">
            <div class="price">{{ $price }}</div>
            <h2>
                <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productView',[$product->id, urlencode($product->product_name)]) }}">{{ $product->product_name }}</a>
            </h2>

            <div class="short-description">
                {!! $product->short_description !!}
            </div>
            <div class="amenities">
                @foreach ($product->categories as $category)
                    <label class="label label-primary" title="{{ $category->category_name }}">{{ $category->category_name }}</label>
                @endforeach
            </div>
        </div>
    </div>
</div>