<select name="countryId" id="{{ $fieldId or 'countryId' }}" class="form-control">
    @foreach ($regions as $region)
        <optgroup label="{{ $region->region_name }}">
            @foreach ($region->countries as $country)
                <option value="{{ $country->id }}"{{ (isset($cart) && $cart->countryId == $country->id) ? ' selected' : '' }}>{{ $country->country }}</option>
            @endforeach
        </optgroup>
    @endforeach
</select>