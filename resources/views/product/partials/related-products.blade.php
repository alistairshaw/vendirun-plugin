<ul class="related-products">
    @foreach ($product->related_products as $product)
        <li>
            @include('vendirun::product.result')
        </li>
    @endforeach
</ul>