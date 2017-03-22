<ul class="related-products">
    @foreach ($relatedProducts as $product)
        <li>
            @include('vendirun::product.result', ['productDisplay' => $product])
        </li>
    @endforeach
</ul>