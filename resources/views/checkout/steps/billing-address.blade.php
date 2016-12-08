<div class="billing-address">
    <h2>Billing Address</h2>
    @if ($cart->shippingApplies())
        <div class="form-group">
            <label class="checkbox">
                <input type="checkbox" value="1" name="billingAddressSameAsShipping" id="billingAddressSameAsShipping" checked>
                {{ trans('vendirun::checkout.billingAddressSameAsShipping') }}
            </label>
        </div>
    @endif
    @if ($customer && $defaultAddress)
        <div class="js-billing-address-form">
            <h3>{{ trans('vendirun::customer.selectAddress') }}</h3>
            @include('vendirun::customer.partials.address-select', ['selected' => $defaultAddress, 'prefix' => 'billing'])
        </div>
    @else
        @include('vendirun::customer.partials.address-form', ['prefix' => 'billing', 'address' => ['countryId' => Request::get('countryId', 79)]])
    @endif
</div>