@if(!Session::get('token'))
    @include('vendirun::customer.partials.login-form')
@else
    <div class="large-notice">
        <div class="alert alert-success">
            <p>{{ trans('vendirun::standard.currentlyLoggedIn') }}
                <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.logout') }}">{{ trans('vendirun::standard.clickToLogOut') }}</a>
            </p>
        </div>
    </div>
@endif