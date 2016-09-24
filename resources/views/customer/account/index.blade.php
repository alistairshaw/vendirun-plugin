@extends('vendirun::layouts.customer-account')
@section('title', $pageTitle)
@section('description', trans('vendirun::customer.account'))
@section('keywords', '')
@section('body-class', 'vendirun-app customer-account')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::customer.account') }}</h1>
        <div class="inner-container">

            <div class="customer-account-details">

                <h2>Your Details</h2>
                <div class="customer-account-details--section">
                    <div class="account-item">
                        <label>{{ trans('vendirun::forms.email') }}:</label>
                        <div class="account-value">{{ $customer->getPrimaryEmail() }}&nbsp;</div>
                    </div>
                    <div class="account-item">
                        <label>{{ trans('vendirun::forms.fullName') }}:</label>
                        <div class="account-value">{{ $customer->fullName() }}</div>
                    </div>
                    <div class="account-item">
                        <label>{{ trans('vendirun::forms.telephone') }}:</label>
                        <div class="account-value">{{ $customer->getPrimaryTelephone() }}&nbsp;</div>
                    </div>
                </div>

                <h2>Company Details</h2>
                <div class="customer-account-details--section">
                    <div class="account-item">
                        <label>{{ trans('vendirun::forms.companyName') }}:</label>
                        <div class="account-value">{{ $customer->getCompanyName() }}&nbsp;</div>
                    </div>
                    <div class="account-item">
                        <label>{{ trans('vendirun::forms.jobRole') }}:</label>
                        <div class="account-value">{{ $customer->getJobRole() }}&nbsp;</div>
                    </div>
                    <div class="account-item">
                        <label>{{ trans('vendirun::forms.companyTaxNumber') }}:</label>
                        <div class="account-value">{{ $customer->getTaxNumber() }}&nbsp;</div>
                    </div>
                </div>

            </div>

            <div class="customer-account-addresses">
                <h2>{{ trans('vendirun::customer.addresses') }}</h2>
                @if (count($customer->getAddresses()) == 0)
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i>
                        You have not added any addresses yet. <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.address.add') }}">Add one now</a>?
                    </div>
                @endif
                @include('vendirun::customer.partials.address-select', ['showSelector' => false])
                <p>
                    <a href="#" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add New Address</a>
                </p>
            </div>
        </div>
    </div>
@stop