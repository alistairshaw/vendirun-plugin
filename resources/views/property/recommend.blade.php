@extends('vendirun::layouts.standard')
@section('title', $property->title)
@section('description', $property->short_description)
@section('keywords', $property->keywords)
@section('body-class', 'cms-property-recommend')
@section('content')

    <div class="container">
        <h1>Send this property to a friend</h1>
        <div class="row">
            <div class="col-sm-8">
                @include('vendirun::forms.recommend-a-friend')
                <br><br>
            </div>
            <div class="col-sm-4 property-search type1">
                @include('vendirun::property.result', ['property' => $property, 'limitImages' => 1, 'abbreviatedButtons' => true])
            </div>
        </div>
    </div>

@stop