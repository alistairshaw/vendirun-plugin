@if (CustomerHelper::checkLoggedinCustomer())
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ $loggedInName }} <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            @include('vendirun::customer.account.partials.nav-items')
        </ul>
    </li>
@else
    <li><a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.register') }}">{{ trans('vendirun::standard.login') }}</a></li>
@endif