<div class="js-variation-choice">
    <h2>{{ $selectedVariation->getName() }}</h2>

    @if (count($product->getVariations()) > 1)
        <h3>Choose a different variation</h3>
        <ul class="variations">
            @foreach ($product->getVariations() as $variation)
                @if ($variation->getId() !== $selectedVariation->getId())
                    <li>
                        <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productView', ['productId' => $productDisplay['id'], 'productName' => urlencode(strtolower($productDisplay['productName'])), 'productVariationId' => $variation->getId()]) }}">
                            {{ $variation->getName() }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
</div>
<input type="hidden" id="productVariationId" name="productVariationId" value="{{ $selectedVariation->getId() }}">