@if ($cart->totalProducts() > 0)
    <div class="cart-table">
        @foreach ($cart->displayItems() as $item)
            <div class="cart-column js-cart-item" data-id="{{ $item['product']['variations'][0]['id'] }}">
                <div class="cart-item">
                    <div class="image">
                        @include('vendirun::product.partials.product-images', ['productDisplay' => $item['product'], 'limitImages' => 1])
                    </div>
                    <div class="wr">
                        <h3>{{ $item['product']['productName'] }}</h3>
                        <h4>
                            {{ $item['product']['variations'][0]['name'] }}<br>
                            <small>{{ $item['product']['variations'][0]['sku'] }}</small>
                        </h4>
                        <div class="price">{{ $item['product']['variations'][0]['price'] }}</div>
                        <div class="quantity js-quantity-buttons">
                            <a class="js-decrease-quantity"
                               data-id="{{ $item['product']['variations'][0]['id'] }}"
                               href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productRemoveFromCart', ['productVariationId' => $item['product']['variations'][0]['id']]) }}">
                                <i class="fa fa-minus-circle"></i>
                            </a>
                            <span>{{ $item['quantity'] }}</span>
                            <a class="js-increase-quantity"
                               data-id="{{ $item['product']['variations'][0]['id'] }}"
                               href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productAddToCart', ['productVariationId' => $item['product']['variations'][0]['id']]) }}">
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