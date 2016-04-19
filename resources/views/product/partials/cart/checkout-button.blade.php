<div class="checkout-button">
    <h2 class="price">
        <small>{{ trans('vendirun::product.totalCartAmount') }}</small>
        <br>
        <span>{{ CurrencyHelper::formatWithCurrency($cart->displayTotal(), false, '') }}</span>
    </h2>
    <div class="shipping">
        <small>Shipping</small><br>
        <span>{{ $cart->shipping() === null ? 'NOT AVAILABLE' : CurrencyHelper::formatWithCurrency($cart->displayShipping(), false, '') }}</span>
    </div>
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.checkout', ['countryId' => $cart->getCountryId(), 'shippingTypeId' => $cart->getShippingType()]) }}" class="btn btn-primary"><i class="fa fa-credit-card"></i> {{ trans('vendirun::product.checkout') }}</a>
</div>