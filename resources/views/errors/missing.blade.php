@extends('vendirun::layouts.standard')
@section('title', '404 Page Not Found')
@section('description', '')
@section('keywords', '')
@section('body-class', 'vendirun-app four-oh-four')
@section('content')
    <div class="large-notice">
        <h1>404</h1>
        <p>{{ trans('vendirun::standard.fourOhFour') }}</p>
    </div>
@stop