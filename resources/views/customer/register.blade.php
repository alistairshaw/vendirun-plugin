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

                    <form method="POST" action="{{ route('vendirun.doRegister') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="form_id" value="Website Registration Form">
                        <h2>{{ trans('vendirun::standard.register') }}</h2>

                        <div class="form-group">
                            <label for=full_name">{{ trans('vendirun::forms.fullName') }}</label>
                            <input type="text" class="form-control" name="full_name" id="full_name" placeholder="{{ trans('vendirun::forms.fullName') }}">
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('vendirun::forms.email') }}</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="{{ trans('vendirun::forms.email') }}">
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('vendirun::forms.password') }}</label>
                            <input type="password" class="form-control" name="password" placeholder="{{ trans('vendirun::forms.password') }}">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">{{ trans('vendirun::forms.passwordConfirm') }}</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('vendirun::forms.passwordConfirm') }}">
                        </div>

                        <div class="form-group">
                            <label for="telephone">{{ trans('vendirun::forms.telephone') }}</label>
                            <input type="text" class="form-control" name="telephone" id="telephone" placeholder="{{ trans('vendirun::forms.telephone') }}">
                        </div>

                        <div class="form-group pull-right">
                            <button type="submit" class="btn btn-primary">{{ trans('vendirun::standard.register') }}</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form method="POST" action="{{ route('vendirun.doLogin') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h2>{{ trans('vendirun::standard.login') }}</h2>

                        <div class="form-group">
                            <label for="email_login">{{ trans('vendirun::forms.email') }}</label>
                            <input type="text" class="form-control" name="email_login" id="email_login" placeholder="{{ trans('vendirun::forms.email') }}">
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('vendirun::forms.password') }}</label>
                            <input type="password" class="form-control" name="password" placeholder="{{ trans('vendirun::forms.password') }}">
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">{{ trans('vendirun::standard.login') }}</button>
                            <br>
                            <br>
                            <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.passwordRecovery') }}">{{ trans('vendirun::forms.passwordForgotten') }}</a>
                        </div>
                    </form>
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