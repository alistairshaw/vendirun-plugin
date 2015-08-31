{!! Form::open(['route' => 'vendirun.propertySearch']) !!}
<h3>Refine your search</h3>
<div class="form-inputs">
    <div class="form-group">
        {!! Form::label('location', 'Location') !!}
        {!! Form::text('location', (isset($searchParams['location']) ? $searchParams['location'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('reference', 'Reference') !!}
        {!! Form::text('reference', (isset($searchParams['reference']) ? $searchParams['reference'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('price_range_from', 'Price Range From') !!}
        {!! Form::select('price_range_from', $priceArray, (isset($searchParams['price_range_from']) ? $searchParams['price_range_from'] : ''), ['class' => 'form-control']) !!}
        <br/>
        {!! Form::label('price_range_to', 'Price Range To') !!}
        {!! Form::select('price_range_to', $priceArray, (isset($searchParams['price_range_to']) ? $searchParams['price_range_to'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('bedrooms', 'Bedrooms') !!}
        {!! Form::text('bedrooms', (isset($searchParams['bedrooms']) ? $searchParams['bedrooms'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('bathrooms', 'Bathrooms') !!}
        {!! Form::text('bathrooms', (isset($searchParams['bathrooms']) ? $searchParams['bathrooms'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('propertytype', 'Property Type') !!}
        {!! Form::select('propertytype', $propertyTypeArray, (isset($searchParams['propertytype']) ? $searchParams['propertytype'] : ''), ['class' => 'form-control']) !!}
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
</div>
{!! Form::close() !!}