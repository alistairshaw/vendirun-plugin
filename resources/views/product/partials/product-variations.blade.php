<div class="js-variation-choice">
    <h2>{{ $selectedVariation->name }}</h2>

    @if (count($product->variations) > 1)
        <h3>Choose a different variation</h3>
        <ul class="variations">
            @foreach ($product->variations as $var)
                @if ($var->id !== $selectedVariation->id)
                    <li>
                        <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productView', ['productId' => $product->id, 'productName' => urlencode(strtolower($product->product_name)), 'productVariationId' => $var->id]) }}">
                            {{ $var->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
</div>
<input type="hidden" id="productVariationId" name="productVariationId" value="{{ $selectedVariation->id }}">
<input type="hidden" id="availableSizes" value="{{ json_encode($product->sizes) }}">
<input type="hidden" id="availableColors" value="{{ json_encode($product->colors) }}">
<input type="hidden" id="availableTypes" value="{{ json_encode($product->types) }}">