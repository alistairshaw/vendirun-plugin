<li class="cart-widget">
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productCart') }}">
        <i class="fa fa-shopping-cart"></i>
        {{ $cart->totalProducts }}
    </a>
</li>