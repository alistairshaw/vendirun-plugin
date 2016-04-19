@if(!Session::get('token'))
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.register') }}"><i class="fa fa-user"></i> {{ trans('vendirun::standard.login') }}</a>
@else
    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.logout') }}"><i class="fa fa-user"></i> {{ trans('vendirun::forms.logout') }}</a>
@endif