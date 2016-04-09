@extends('vendirun::layouts.standard')
@section('title', 'New Registration')
@section('description', '')
@section('keywords', '')
@section('body-class', 'customer-registration')
@section('content')
    <div class="container">
        @if(!Session::get('token'))

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li><i class="fa fa-exclamation-triangle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">

                    {!! Form::open(array('route' => 'vendirun.doRegister', 'autocomplete' => 'off')) !!}
                    <p></p>
                    <h2>{{ trans('vendirun::standard.register') }}</h2>

                    <p></p>

                    <div class="form-group">
                        {!! Form::label('full_name', trans('vendirun::forms.fullName') . ':*') !!}
                        {!! Form::text('full_name', Input::old('full_name'), array('placeholder'=>trans('vendirun::forms.fullName'), 'class'=>'form-control')) !!}
                        @if ($errors->has('full_name')) <p class="error">{{ $errors->first('full_name') }}</p> @endif
                        {!! Form::hidden('form_id', 'Website Registration Form') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', trans('vendirun::forms.email') . ':*') !!}
                        {!! Form::text('email', Input::old('email'), array('placeholder'=>trans('vendirun::forms.email'), 'class'=>'form-control')) !!}
                        @if ($errors->has('email')) <p class="error">{{ $errors->first('email') }}</p> @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', trans('vendirun::forms.password') . ':*') !!}
                        {!! Form::password('password', array('placeholder'=>trans('vendirun::forms.password'), 'class'=>'form-control')) !!}
                        @if ($errors->has('password')) <p class="error">{{ $errors->first('Password') }}</p> @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('password_confirmation', trans('vendirun::forms.passwordConfirm') . ':*') !!}
                        {!! Form::password('password_confirmation', array('placeholder'=>trans('vendirun::forms.passwordConfirm'), 'class'=>'form-control')) !!}
                        @if ($errors->has('password_confirmation'))
                            <p class="error">{{ $errors->first('password_confirmation') }}</p> @endif
                    </div>

                    <div class="form-group">
                        {!! Form::label('telephone', trans('vendirun::forms.telephone') . ':') !!}
                        {!! Form::text('telephone',Input::old('full_name'), array('placeholder'=>trans('vendirun::forms.telephone'), 'class'=>'form-control')) !!}
                    </div>

                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary">{{ trans('vendirun::standard.register') }}</button>
                    </div>
                    {!! Form::close() !!}


                </div>
                <div class="col-md-6">
                    {!! Form::open(array('route' => 'vendirun.doLogin', 'autocomplete' => 'off')) !!}
                    <p></p>

                    <h2>{{ trans('vendirun::standard.login') }}</h2>

                    <div class="form-group">
                        {!! Form::label('email_login', trans('vendirun::forms.email') . ':*') !!}
                        {!! Form::text('email_login', Input::old('email_login'), array('placeholder'=>trans('vendirun::forms.email'), 'class'=>'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', trans('vendirun::forms.password') . ':*') !!}
                        {!! Form::password('password', array('placeholder'=>trans('vendirun::forms.password'), 'class'=>'form-control')) !!}
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">{{ trans('vendirun::standard.login') }}</button>
                        <br>
                        <br>
                        <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.passwordRecovery') }}">{{ trans('vendirun::forms.passwordForgotten') }}</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        @else
            <div class="large-notice">
                <div class="alert alert-success">
                    <p>{{ trans('vendirun::standard.currentlyLoggedIn') }}  <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.logout') }}">{{ trans('vendirun::standard.clickToLogOut') }}</a></p>
                </div>
            </div>
        @endif
    </div>

@stop