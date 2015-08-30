@extends('vendirun::layouts.standard')
@section('title', 'New Registration')
@section('description', '')
@section('keywords', '')
@section('body-class', 'customer-registration')
@section('content')
    <div class="container">
        @if(!Session::get('token'))
            <div class="row">
                <div class="col-md-6">

                    {!! Form::open(array('route' => 'vendirun.doRegister', 'autocomplete' => 'off')) !!}
                    <p></p>
                    <h2>Register account</h2>

                    <p></p>

                    <div class="form-group">
                        {!! Form::label('full_name', 'Full Name:*') !!}
                        {!! Form::text('full_name', Input::old('full_name'), array('placeholder'=>'Full name', 'class'=>'form-control')) !!}
                        @if ($errors->has('full_name')) <p class="error">{{ $errors->first('full_name') }}</p> @endif
                        {!! Form::hidden('form_id', 'Website Registration Form') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', 'Email:*') !!}
                        {!! Form::text('email', Input::old('email'), array('placeholder'=>'Email Address', 'class'=>'form-control')) !!}
                        @if ($errors->has('email')) <p class="error">{{ $errors->first('email') }}</p> @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Password:*') !!}
                        {!! Form::password('password', array('placeholder'=>'password', 'class'=>'form-control')) !!}
                        @if ($errors->has('password')) <p class="error">{{ $errors->first('Password') }}</p> @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Confirm password:*') !!}
                        {!! Form::password('password_confirmation', array('placeholder'=>'Confirm password', 'class'=>'form-control')) !!}
                        @if ($errors->has('password_confirmation')) <p class="error">{{ $errors->first('password_confirmation') }}</p> @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('telephone', 'Telephone:') !!}
                        {!! Form::text('telephone',Input::old('full_name'), array('placeholder'=>'Telephone', 'class'=>'form-control')) !!}
                    </div>

                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                    {!! Form::close() !!}


                </div>
                <div class="col-md-6">
                    {!! Form::open(array('route' => 'vendirun.doLogin', 'autocomplete' => 'off')) !!}
                    <p></p>

                    <h2>Login </h2>

                    @if(Session::has('alert_message_failure'))
                        <div class="alert alert-danger js-fade-out" data-time="5">
                            <i class="fa fa-exclamation-triangle"></i> {!! Session::get('alert_message_failure') !!}
                        </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('email_login', 'Email:*') !!}
                        {!! Form::text('email_login', Input::old('email_login'), array('placeholder'=>'Email Address', 'class'=>'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Password:*') !!}
                        {!! Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control')) !!}
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <br>
                        <br>
                        <a href="{{ route('vendirun.passwordRecovery') }}">forgotten password?</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        @else
            <div class="large-notice">
                <div class="alert alert-success">
                    <p>You are currently logged in click <a href="{{ route('vendirun.logout') }}">here</a> to logout</p>
                </div>
            </div>
        @endif
    </div>

@stop