<ul class="related-products">
    @foreach ($product->getRelatedProducts() as $product)
        <li>
            @include('vendirun::product.result')
        </li>
    @endforeach
</ul>