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
                    <form method="POST" action="{{ route('vendirun.doPasswordReset') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h2>{{ trans('vendirun::forms.resetPassword') }}</h2>

                        @if(isset($alertMessage))
                            <div class="alert alert-danger js-fade-out" data-time="5">
                                <i class="fa fa-exclamation-triangle"></i> {{ $alertMessage }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="email">{{ trans('vendirun::forms.email') }}</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="{{ trans('vendirun::forms.email') }}">
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('vendirun::forms.newPassword') }}</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('vendirun::forms.resetPassword') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop