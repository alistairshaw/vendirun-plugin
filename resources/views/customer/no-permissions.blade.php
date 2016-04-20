@extends('vendirun::layouts.standard')
@section('title', 'Permission Denied')
@section('description', '')
@section('keywords', '')
@section('body-class', 'vendirun-app no-permissions')
@section('content')
    <div class="large-notice">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h1>{{ trans('vendirun::customer.noPermissions') }}</h1>
                    <p>{{ trans('vendirun::customer.noPermissionsText') }}</p>
                </div>
            </div>
        </div>
    </div>
@stop