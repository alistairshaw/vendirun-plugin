<div class="checkout-button">
    <h2 class="price">
        <small>{{ trans('vendirun::product.totalCartAmount') }}</small>
        <br>
        {{ CurrencyHelper::formatWithCurrency($cart->total, false, '') }}
    </h2>
    <a href="#" class="btn btn-primary"><i class="fa fa-credit-card"></i> {{ trans('vendirun::product.checkout') }}</a>
</div>