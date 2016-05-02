@if (CustomerHelper::checkLoggedinCustomer())
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ $loggedInName }} <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.account.orders') }}">{{ trans('vendirun::product.orderHistory') }}</a></li>
            <li class="divider"></li>
            <li><a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.logout') }}">{{ trans('vendirun::standard.logout') }}</a></li>
        </ul>
    </li>
@else
    <li><a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.register') }}">{{ trans('vendirun::standard.login') }}</a></li>
@endif