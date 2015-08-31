@extends('vendirun::layouts.standard')
@section('title', 'Password Recovery')
@section('description', '')
@section('keywords', '')
@section('body-class', 'customer-password-recovery')
@section('content')
    <div class="large-notice">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    {!! Form::open(array('route' => 'vendirun.doPasswordRecovery', 'autocomplete' => 'off')) !!}
                    <p></p>

                    <h2>Recover your Password</h2>

                    @if(isset($alertMessage))
                        <div class="alert alert-danger js-fade-out" data-time="5">
                            <i class="fa fa-exclamation-triangle"></i> {{ $alertMessage }}
                        </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('email', 'Enter your Email Address:') !!}
                        {!! Form::text('email', Input::old('email'), array('placeholder'=>'Email Address', 'class'=>'form-control')) !!}
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Reset my Password</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop