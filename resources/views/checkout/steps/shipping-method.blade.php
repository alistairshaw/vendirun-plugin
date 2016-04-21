<div class="shipping-method">
    <div class="method-select">
        <div class="form-group">
            @if (count($cart->getAvailableShippingTypes()) <= 1)
                <div class="form-control-static">{{ $cart->getShippingType() }}</div>
            @else
                <select class="form-control" name="shippingTypeId" id="shippingTypeId">
                    @foreach ($cart->getAvailableShippingTypes() as $type)
                        <option value="{{ $type }}"{{ ($type == $cart->getShippingType()) ? ' selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
    <div class="shipping-price">
        <div class="price js-current-shipping">
            {{ CurrencyHelper::formatWithCurrency($cart->displayShipping()) }}
        </div>
    </div>
    <div class="options">
        <input type="submit" class="btn btn-default js-recalculate-shipping-button" name="recalculateShipping" value="Recalculate Shipping" />
    </div>
</div>