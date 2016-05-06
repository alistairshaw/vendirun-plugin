<div class="product-result js-product-result">
    <div class="wrapper">
        <div class="part-one">
            @include('vendirun::product.partials.product-images', ['limitImages' => 1])
        </div>
        <div class="details">
            <h2>
                <a href="{{ $viewProductRoute }}">{{ $productDisplay['productName'] }}</a>
            </h2>
            <div class="price">{{ $productDisplay['price'] }}</div>

            <div class="short-description">
                {!! $productDisplay['shortDescription'] !!}
            </div>
            <div class="buttons">
                @include('vendirun::product.partials.product-buttons', ['abbreviatedButtons' => true, 'productButtons' => ['details', 'enquire', 'favourite', 'recommend', 'add-to-cart']])
            </div>
        </div>
    </div>
</div>