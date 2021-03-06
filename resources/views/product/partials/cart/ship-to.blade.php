@if ($cart->shippingApplies())
    <div class="ship-to">
        <h3>Change Shipping Destination</h3>
        <form method="GET">
            <div class="form-group">
                <label class="sr-only" for="shipToCountryId">Choose your country:</label>
                @include('vendirun::customer.partials.country-select', ['fieldId' => 'shipToCountryId', 'selected' => $cart->getCountryId()])
            </div>
            @if (isset($cart) && count($cart->getAvailableShippingTypes()) > 0)
                <div class="form-group">
                    <label class="sr-only" for="shipToShippingType">Choose your shipping type:</label>
                    <select name="shippingType" id="shipToShippingType" class="form-control">
                        @foreach ($cart->getAvailableShippingTypes() as $type)
                            <option value="{{ $type }}"{{ (isset($cart) && $cart->getShippingType() == $type) ? ' selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="form-group">
                <button type="submit" class="btn btn-default"><i class="fa fa-truck"></i> Calculate Shipping</button>
            </div>
        </form>
    </div>
@endif