<div class="checkout-button">
    <h2 class="price">
        <small>{{ trans('vendirun::product.totalCartAmount') }}</small>
        <br>
        <span class="js-shopping-cart-total">{{ CurrencyHelper::formatWithCurrency($cartValues['displayTotal'], false, '') }}</span>
    </h2>
    <div class="shipping">
        <small>Shipping</small><br>
        <span class="js-shopping-cart-shipping-total">{{ $cartValues['shipping'] === null ? 'NOT AVAILABLE' : CurrencyHelper::formatWithCurrency($cartValues['displayShipping'], false, '') }}</span>
    </div>
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.checkout', ['countryId' => $cart->getCountryId(), 'shippingTypeId' => $cart->getShippingType()]) }}" class="btn btn-primary"><i class="fa fa-credit-card"></i> {{ trans('vendirun::product.checkout') }}</a>
</div>