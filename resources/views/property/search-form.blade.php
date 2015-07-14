<form method="post" action="{{ route('vendirun.propertySearch') }}" autocomplete="off">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <p><strong>Refine your search</strong></p>
    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" class="form-control" name="location" id="location" value="{{ isset($searchParams['location']) ? $searchParams['location'] : '' }}">
    </div>
    <div class="form-group">
        <label for="priceRangeFrom">Price Range</label>
        <select class="form-control select2" name="price_range_from" id="priceRangeFrom" data-placeholder="From" data-allow-clear="true">
            <option value="">From</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '10000') ? 'selected' : ''  }} value="10000">&euro;10,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '50000') ? 'selected' : ''  }} value="50000">&euro;50,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '100000') ? 'selected' : ''  }} value="100000">&euro;100,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '200000') ? 'selected' : ''  }} value="200000">&euro;200,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '300000') ? 'selected' : ''  }} value="300000">&euro;300,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '400000') ? 'selected' : ''  }} value="400000">&euro;400,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '500000') ? 'selected' : ''  }} value="500000">&euro;500,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '600000') ? 'selected' : ''  }} value="600000">&euro;600,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '700000') ? 'selected' : ''  }} value="700000">&euro;700,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '800000') ? 'selected' : ''  }} value="800000">&euro;800,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '900000') ? 'selected' : ''  }} value="900000">&euro;900,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '1000000') ? 'selected' : ''  }} value="1000000">&euro;1000,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '1500000') ? 'selected' : ''  }} value="1500000">&euro;1500,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '2000000') ? 'selected' : ''  }} value="2000000">&euro;2000,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '2500000') ? 'selected' : ''  }} value="2500000">&euro;2500,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '3000000') ? 'selected' : ''  }} value="3000000">&euro;3000,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '3500000') ? 'selected' : ''  }} value="3500000">&euro;3500,000</option>
            <option {{ (isset($searchParams['price_range_from']) && $searchParams['price_range_from'] == '4000000') ? 'selected' : ''  }} value="4000000">&euro;4000,000</option>
        </select>
        <br/>
        <label for="priceRangeTo" class="sr-only">Price Range Up To</label>
        <select class="form-control select2" name="price_range_to" id="priceRangeTo" data-placeholder="To" data-allow-clear="true">
            <option value="">To</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '10000') ? 'selected' : ''  }} value="10000">&euro;10,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '50000') ? 'selected' : ''  }} value="50000">&euro;50,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '100000') ? 'selected' : ''  }} value="100000">&euro;100,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '200000') ? 'selected' : ''  }} value="200000">&euro;200,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '300000') ? 'selected' : ''  }} value="300000">&euro;300,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '400000') ? 'selected' : ''  }} value="400000">&euro;400,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '500000') ? 'selected' : ''  }} value="500000">&euro;500,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '600000') ? 'selected' : ''  }} value="600000">&euro;600,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '700000') ? 'selected' : ''  }} value="700000">&euro;700,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '800000') ? 'selected' : ''  }} value="800000">&euro;800,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '900000') ? 'selected' : ''  }} value="900000">&euro;900,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '1000000') ? 'selected' : ''  }} value="1000000">&euro;1000,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '1500000') ? 'selected' : ''  }} value="1500000">&euro;1500,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '2000000') ? 'selected' : ''  }} value="2000000">&euro;2000,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '2500000') ? 'selected' : ''  }} value="2500000">&euro;2500,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '3000000') ? 'selected' : ''  }} value="3000000">&euro;3000,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '3500000') ? 'selected' : ''  }} value="3500000">&euro;3500,000</option>
            <option {{ (isset($searchParams['price_range_to']) && $searchParams['price_range_to'] == '4000000') ? 'selected' : ''  }} value="4000000">&euro;4000,000</option>
        </select>
    </div>
    <div class="form-group">
        <label for="bedrooms">Bedrooms</label>
        <select class="form-control select2" name="bedrooms" id="bedrooms" data-placeholder="Any" data-allow-clear="true">
            <option value="">Any</option>
            <option {{ (isset($searchParams['bedrooms']) && $searchParams['bedrooms'] == '1') ? 'selected' : ''  }} value="1">1+</option>
            <option {{ (isset($searchParams['bedrooms']) && $searchParams['bedrooms'] == '2') ? 'selected' : ''  }} value="2">2+</option>
            <option {{ (isset($searchParams['bedrooms']) && $searchParams['bedrooms'] == '3') ? 'selected' : ''  }} value="3">3+</option>
            <option {{ (isset($searchParams['bedrooms']) && $searchParams['bedrooms'] == '4') ? 'selected' : ''  }} value="4">4+</option>
            <option {{ (isset($searchParams['bedrooms']) && $searchParams['bedrooms'] == '5') ? 'selected' : ''  }} value="5">5+</option>
            <option {{ (isset($searchParams['bedrooms']) && $searchParams['bedrooms'] == '6') ? 'selected' : ''  }} value="6">6+</option>
            <option {{ (isset($searchParams['bedrooms']) && $searchParams['bedrooms'] == '7') ? 'selected' : ''  }} value="7">7+</option>
            <option {{ (isset($searchParams['bedrooms']) && $searchParams['bedrooms'] == '8') ? 'selected' : ''  }} value="8">8+</option>
        </select>
    </div>
    <div class="form-group">
        <label for="bathrooms">Bathrooms</label>
        <select class="form-control select2" name="bathrooms" id="bathrooms" data-placeholder="Any" data-allow-clear="true">
            <option value="">Any</option>
            <option {{ (isset($searchParams['bathrooms']) && $searchParams['bathrooms'] == '1') ? 'selected' : ''  }} value="1">1+</option>
            <option {{ (isset($searchParams['bathrooms']) && $searchParams['bathrooms'] == '2') ? 'selected' : ''  }} value="2">2+</option>
            <option {{ (isset($searchParams['bathrooms']) && $searchParams['bathrooms'] == '3') ? 'selected' : ''  }} value="3">3+</option>
            <option {{ (isset($searchParams['bathrooms']) && $searchParams['bathrooms'] == '4') ? 'selected' : ''  }} value="4">4+</option>
            <option {{ (isset($searchParams['bathrooms']) && $searchParams['bathrooms'] == '5') ? 'selected' : ''  }} value="5">5+</option>
            <option {{ (isset($searchParams['bathrooms']) && $searchParams['bathrooms'] == '6') ? 'selected' : ''  }} value="6">6+</option>
            <option {{ (isset($searchParams['bathrooms']) && $searchParams['bathrooms'] == '7') ? 'selected' : ''  }} value="7">7+</option>
            <option {{ (isset($searchParams['bathrooms']) && $searchParams['bathrooms'] == '8') ? 'selected' : ''  }} value="8">8+</option>
        </select>
    </div>
    <div class="form-group">
        <label for="propertyType">Property Category</label>
        <select class="form-control select2" name="propertytype" id="propertyType" data-placeholder="Any" data-allow-clear="true">
            <option value="">Any</option>
            @foreach($categories as $category)
                <option {{ (isset($searchParams['propertytype']) && $searchParams['propertytype'] == $category->id) ? 'selected' : ''  }} value="{{ $category->id }}"> {{ $category->category_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="keywords">Keywords</label>
        <input type="text" class="form-control" name="keywords" id="keywords" value="{{ isset($searchParams['strings']) ? implode(',', (array)$searchParams['strings']) : '' }}">
    </div>

    <div class="form-group text-right">
        <button type="button" class="btn btn-default js-close-filter"><i class="fa fa-chevron-left"></i></button>
        <a href="{{ route('vendirun.propertyClearSearch') }}" class="btn btn-default">Clear</a>
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>