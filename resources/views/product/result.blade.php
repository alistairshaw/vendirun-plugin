<div class="product-result">
    <div class="wrapper">
        <div class="part-one">
            @include('vendirun::product.partials.product-images', ['limitImages' => 1])
        </div>
        <div class="details">
            <h2>
                <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productView',[$product->id, urlencode($product->product_name)]) }}">{{ $product->product_name }}</a>
            </h2>
            <div class="price">{{ $price }}</div>

            <div class="short-description">
                {!! $product->short_description !!}
            </div>
            <div class="buttons">
                @include('vendirun::product.partials.product-buttons', ['abbreviatedButtons' => true, 'productButtons' => ['details', 'enquire', 'favourite', 'recommend', 'add-to-cart']])
            </div>
        </div>
    </div>
</div>