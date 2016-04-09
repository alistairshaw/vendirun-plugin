@if ($cart->totalProducts > 0)
    <div class="cart-table">
        @foreach ($cart->items as $item)
            <div class="cart-column">
                <div class="cart-item">
                    <div class="image">
                        @include('vendirun::product.partials.product-images', ['product' => $item->product, 'limitImages' => 1])
                    </div>
                    <h3>{{ $item->product->product_name }}</h3>
                    <h4>{{ $item->productVariation->name }}<br>
                        <small>{{ $item->product->product_sku . $item->productVariation->variation_sku }}</small>
                    </h4>
                    <div class="price">{{ CurrencyHelper::formatWithCurrency($item->basePrice) }}</div>
                    <div class="quantity">
                        <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productRemoveFromCart', ['productVariationId' => $item->productVariation->id]) }}">
                            <i class="fa fa-minus-circle"></i>
                        </a>
                        <span>{{ $item->quantity }}</span>
                        <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productAddToCart', ['productVariationId' => $item->productVariation->id]) }}">
                            <i class="fa fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    @include('vendirun::product.partials.cart.empty-cart')
@endif