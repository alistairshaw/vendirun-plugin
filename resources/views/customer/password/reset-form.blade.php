@extends('vendirun::layouts.standard')
@section('title', 'Password Reset')
@section('description', '')
@section('keywords', '')
@section('body-class', 'customer-password-reset')
@section('content')
    <div class="large-notice">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    {!! Form::open(array('route' => 'vendirun.doPasswordReset', 'autocomplete' => 'off')) !!}
                    {!! Form::hidden('token', $token) !!}
                    <p></p>

                    <h2>Reset your Password</h2>

                    @if(isset($alertMessage))
                        <div class="alert alert-danger js-fade-out" data-time="5">
                            <i class="fa fa-exclamation-triangle"></i> {{ $alertMessage }}
                        </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('email', 'Enter your Email Address:') !!}
                        {!! Form::text('email', Input::old('email'), ['placeholder'=>'Email Address', 'class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Enter your New Password:') !!}
                        {!! Form::password('password', ['class'=>'form-control']) !!}
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