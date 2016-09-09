@extends('vendirun::layouts.standard')
@section('title', $pageTitle)
@section('description', '')
@section('keywords', '')
@section('body-class', 'customer-password-reset')
@section('content')
    <div class="large-notice">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h1>{{ trans('vendirun::forms.passwordResetSuccess') }}</h1>
                    <p>{{ trans('vendirun::forms.passwordResetSuccessMessage') }}</p>
                </div>
            </div>
        </div>
    </div>
@stop