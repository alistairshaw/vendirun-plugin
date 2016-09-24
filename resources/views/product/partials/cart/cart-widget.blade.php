<li class="cart-widget">
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productCart') }}">
        <i class="fa fa-shopping-cart"></i>
        <span class="js-total-cart-products">{{ $cart->totalProducts() }}</span>
    </a>
    <div class="cart-added-popup">
        <div class="title">
            {{ trans('vendirun::product.itemAdded') }}
            <div class="pull-right">
                <a href="#" class="js-close-cart-added-popup"><i class="fa fa-remove"></i></a>
            </div>
        </div>
        <div class="product-name"></div>
        <div class="checkout">
            <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productCart') }}" class="go-to-cart">{{ trans('vendirun::product.cart') }}</a>
            <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.checkout') }}" class="go-to-checkout">{{ trans('vendirun::product.checkout') }}</a>
        </div>
    </div>
</li>