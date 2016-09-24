@extends('vendirun::layouts.customer-account')
@section('title', $pageTitle)
@section('description', trans('vendirun::customer.editAddress'))
@section('keywords', '')
@section('body-class', 'vendirun-app customer-account')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::customer.editAddress') }}</h1>
        <form method="post" action="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.address.save') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @include('vendirun::customer.partials.address-form', ['defaultAddress' => $address])
            <div class="form-group text-right">
                <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.account') }}" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Back</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Save</button>
            </div>
        </form>
    </div>
@stop