<li class="cart-widget">
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productCart') }}">
        <i class="fa fa-shopping-cart"></i>
        <span class="js-total-cart-products">{{ $cart->totalProducts() }}</span>
    </a>
</li>