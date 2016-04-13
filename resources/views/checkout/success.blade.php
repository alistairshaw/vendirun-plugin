@extends('vendirun::layouts.standard')
@section('title', 'Order Confirmation')
@section('description', 'Confirmation of your Order')
@section('keywords', '')
@section('body-class', 'checkout')
@section('content')
    <div class="container">
        <h1>{{ trans('vendirun::orderComplete') }}</h1>
        <p>{{ trans('vendirun::thanksForOrder') }}</p>
        <code>Order Details Go Here</code>
    </div>
@stop