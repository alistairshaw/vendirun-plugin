<div class="shipping-method">
    <div class="method-select">
        <div class="form-group">
            <div class="form-control-static js-one-shipping-type {{ count($cart->getAvailableShippingTypes()) > 1 ? 'hidden' : '' }}">{{ $cart->getShippingType() }}</div>
            <select class="form-control js-multiple-shipping-types {{ count($cart->getAvailableShippingTypes()) <= 1 ? 'hidden' : '' }}" name="shippingTypeId" id="shippingTypeId">
                @foreach ($cart->getAvailableShippingTypes() as $type)
                    <option value="{{ $type }}"{{ ($type == $cart->getShippingType()) ? ' selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="shipping-price">
        <div class="price js-display-shipping">
            {{ $displayTotals['displayShipping'] }}
        </div>
    </div>
    <div class="options">
        <input type="submit" class="btn btn-default js-recalculate-shipping-button" name="recalculateShipping" value="Recalculate Shipping"/>
    </div>
</div>