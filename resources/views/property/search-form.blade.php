{!! Form::open(['route' => 'vendirun.propertySearch']) !!}
<div class="form-inputs">
    <div class="form-group">
        {!! Form::label('location', trans('vendirun::property.location')) !!}
        {!! Form::text('location', (isset($searchParams['location']) ? $searchParams['location'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('reference', trans('vendirun::property.reference')) !!}
        {!! Form::text('reference', (isset($searchParams['reference']) ? $searchParams['reference'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('price_range_from', trans('vendirun::property.priceRangeFrom')) !!}
        {!! Form::select('price_range_from', $priceArray, (isset($searchParams['price_range_from']) ? $searchParams['price_range_from'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('price_range_to', trans('vendirun::property.priceRangeTo')) !!}
        {!! Form::select('price_range_to', $priceArray, (isset($searchParams['price_range_to']) ? $searchParams['price_range_to'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('bedrooms', trans('vendirun::property.bedrooms')) !!}
        {!! Form::text('bedrooms', (isset($searchParams['bedrooms']) ? $searchParams['bedrooms'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('bathrooms', trans('vendirun::property.bathrooms')) !!}
        {!! Form::text('bathrooms', (isset($searchParams['bathrooms']) ? $searchParams['bathrooms'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('propertytype', trans('vendirun::property.propertyType')) !!}
        {!! Form::select('propertytype', $propertyTypeArray, (isset($searchParams['propertytype']) ? $searchParams['propertytype'] : ''), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label for="keywords">{{ trans('vendirun::property.keywords') }}</label>
        <input type="text" class="form-control" name="keywords" id="keywords" value="{{ isset($searchParams['strings']) ? implode(',', (array)$searchParams['strings']) : '' }}">
    </div>
    <div class="form-group text-right">
        <button type="button" class="btn btn-default js-close-filter"><i class="fa fa-chevron-left"></i></button>
        <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertyClearSearch') }}" class="btn btn-default">{{ trans('vendirun::forms.clear') }}</a>
        <button type="submit" class="btn btn-primary">{{ trans('vendirun::forms.search') }}</button>
    </div>
</div>
{!! Form::close() !!}