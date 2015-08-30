@extends('vendirun::layouts.standard')
@section('title', $category->category_name)
@section('description', $category->category_description)
@section('keywords', 'Property in ' . $category->category_name)
@section('body-class', 'cms-category')
@section('content')
    <div class="container clearfix">
        @include('vendirun::cms.widgets.property-categories')
    </div>
@stop