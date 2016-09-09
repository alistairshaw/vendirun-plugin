@extends('vendirun::layouts.standard')
@section('title', $pageTitle)
@section('description', '')
@section('keywords', '')
@section('body-class', 'customer-password-recovery')
@section('content')
    <div class="large-notice">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h1>{{ trans('vendirun::forms.passwordRecoverySent') }}</h1>
                    <p>{{ trans('vendirun::forms.passwordRecoveryMessage') }}</p>
                </div>
            </div>
        </div>
    </div>
@stop