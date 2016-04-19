@if ($cart->totalProducts() > 0)
    <div class="cart-table">
        @foreach ($cart->getItems() as $item)
            <div class="cart-column">
                <div class="cart-item">
                    <div class="image">
                        @include('vendirun::product.partials.product-images', ['product' => $item->getProduct(), 'limitImages' => 1])
                    </div>
                    <div class="wr">
                        <h3>{{ $item->getProduct()->product_name }}</h3>
                        <h4>{{ $item->getProductVariation()->name }}<br>
                            <small>{{ $item->getProduct()->product_sku . $item->getProductVariation()->variation_sku }}</small>
                        </h4>
                        <div class="price">{{ CurrencyHelper::formatWithCurrency($item->getProductVariation()->price) }}</div>
                        <div class="quantity">
                            <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productRemoveFromCart', ['productVariationId' => $item->getProductVariation()->id]) }}">
                                <i class="fa fa-minus-circle"></i>
                            </a>
                            <span>{{ $item->getQuantity() }}</span>
                            <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productAddToCart', ['productVariationId' => $item->getProductVariation()->id]) }}">
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    @include('vendirun::product.partials.cart.empty-cart')
@endif