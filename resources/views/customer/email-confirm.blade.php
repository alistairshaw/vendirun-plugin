@extends('vendirun::layouts.standard')
@section('title', $pageTitle)
@section('description', '')
@section('keywords', '')
@section('body-class', 'vendirun-app customer-email-confirmation')
@section('content')
    <div class="large-notice">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h1>{{ trans('vendirun::customer.emailConfirmationSent') }}</h1>
                    <p>{{ trans('vendirun::customer.emailConfirmationText') }}</p>
                </div>
            </div>
        </div>
    </div>
@stop