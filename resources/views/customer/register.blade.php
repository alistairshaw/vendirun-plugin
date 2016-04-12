@extends('vendirun::layouts.standard')
@section('title', 'New Registration')
@section('description', '')
@section('keywords', '')
@section('body-class', 'customer-registration')
@section('content')
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!Session::get('token'))
            <div class="row">
                <div class="col-md-6">
                    @include('vendirun::customer.partials.registration-form')
                </div>
                <div class="col-md-6">
                    @include('vendirun::customer.partials.login-form')
                </div>
            </div>
        @else
            <div class="large-notice">
                <div class="alert alert-success">
                    <p>{{ trans('vendirun::standard.currentlyLoggedIn') }}
                        <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.logout') }}">{{ trans('vendirun::standard.clickToLogOut') }}</a>
                    </p>
                </div>
            </div>
        @endif
    </div>

@stop