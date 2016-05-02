<div class="billing-address">
    <h2>Billing Address</h2>
    <div class="form-group">
        <label class="checkbox">
            <input type="checkbox" value="1" name="billingAddressSameAsShipping" id="billingAddressSameAsShipping" checked>
            {{ trans('vendirun::checkout.billingAddressSameAsShipping') }}
        </label>
    </div>
    @if ($customer && $defaultAddress)
        <div class="js-billing-address-form">
            @include('vendirun::customer.partials.address-select', ['selected' => $defaultAddress, 'prefix' => 'billing'])
        </div>
    @else
        @include('vendirun::customer.partials.address-form', ['prefix' => 'billing'])
    @endif
</div>