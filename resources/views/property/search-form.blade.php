<form method="POST" action="{{ route(LocaleHelper::localePrefix() . 'vendirun.propertySearch') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-inputs">
        <div class="form-group">
            <label for="location">{{ trans('vendirun::property.location') }}</label>
            <input type="text" class="form-control" name="location" id="location" value="{{ isset($searchParams['location']) ? $searchParams['location'] : '' }}">
        </div>
        <div class="form-group">
            <label for="reference">{{ trans('vendirun::property.reference') }}</label>
            <input type="text" class="form-control" name="reference" id="reference" value="{{ isset($searchParams['reference']) ? $searchParams['reference'] : '' }}">
        </div>
        <div class="form-group">
            <label for="price_range_from">{{ trans('vendirun::property.priceRangeFrom') }}</label>
            <select name="price_range_from" id="price_range_from" class="form-control select2">
                @foreach($priceArray as $key => $value)
                    <option value="{{ $key }}"{{ (isset($searchParams['price_range_from']) && $value == $searchParams['price_range_from']) ? ' selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="price_range_to">{{ trans('vendirun::property.priceRangeTo') }}</label>
            <select name="price_range_to" id="price_range_to" class="form-control select2">
                @foreach($priceArray as $key => $value)
                    <option value="{{ $key }}"{{ (isset($searchParams['price_range_to']) && $value == $searchParams['price_range_to']) ? ' selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bedrooms">{{ trans('vendirun::property.bedrooms') }}</label>
            <input type="text" class="form-control" name="bedrooms" id="bedrooms" value="{{ isset($searchParams['bedrooms']) ? $searchParams['bedrooms'] : '' }}">
        </div>
        <div class="form-group">
            <label for="bathrooms">{{ trans('vendirun::property.bathrooms') }}</label>
            <input type="text" class="form-control" name="bathrooms" id="bathrooms" value="{{ isset($searchParams['bathrooms']) ? $searchParams['bathrooms'] : '' }}">
        </div>
        <div class="form-group">
            <label for="propertytype">{{ trans('vendirun::property.propertyType') }}</label>
            <select name="propertytype" id="propertytype" class="form-control select2">
                @foreach($propertyTypeArray as $key => $value)
                    <option value="{{ $key }}"{{ (isset($searchParams['propertytype']) && $key == $searchParams['propertytype']) ? ' selected' : '' }}>{{ $value}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="keywords">{{ trans('vendirun::property.keywords') }}</label>
            <input type="text" class="form-control" name="keywords" id="keywords" value="{{ isset($searchParams['strings']) ? implode(',', (array)$searchParams['strings']) : '' }}">
        </div>
        <div class="form-group text-right">
            @if (Config::get('vendirun.propertyListingsView') == 'type2')
                <button type="button" class="btn btn-default js-close-filter"><i class="fa fa-chevron-left"></i>
                </button>
            @endif
            <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.propertyClearSearch') }}" class="btn btn-default">{{ trans('vendirun::forms.clear') }}</a>
            <button type="submit" class="btn btn-primary">{{ trans('vendirun::forms.search') }}</button>
        </div>
    </div>
</form>