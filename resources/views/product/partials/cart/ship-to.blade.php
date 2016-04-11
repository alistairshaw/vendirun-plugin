<div class="ship-to">
    <h3>Change Shipping Destination</h3>
    <form method="GET">
        <div class="form-group">
            <label class="sr-only" for="shipToCountryId">Choose your country:</label>
            <select name="countryId" id="shipToCountryId" class="form-control">
                @foreach ($regions as $region)
                    <optgroup label="{{ $region->region_name }}">
                        @foreach ($region->countries as $country)
                            <option value="{{ $country->id }}"{{ (isset($cart) && $cart->countryId == $country->id) ? ' selected' : '' }}>{{ $country->country }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        @if (isset($cart) && count($cart->availableShippingTypes) > 0)
            <div class="form-group">
                <label class="sr-only" for="shipToShippingTypeId">Choose your shipping type:</label>
                <select name="shippingTypeId" id="shipToShippingTypeId" class="form-control">
                    @foreach ($cart->availableShippingTypes as $type)
                        <option value="{{ $type }}"{{ (isset($cart) && $cart->shippingType == $type) ? ' selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="form-group">
            <button type="submit" class="btn btn-default"><i class="fa fa-truck"></i> Calculate Shipping</button>
        </div>
    </form>
</div>