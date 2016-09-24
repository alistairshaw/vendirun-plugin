<li{{ $navSelected == 'account' ? ' class=active' : '' }}><a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.account') }}">{{ trans('vendirun::customer.account') }}</a></li>
<li{{ $navSelected == 'orders' ? ' class=active' : '' }}><a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.account.orders') }}">{{ trans('vendirun::product.orderHistory') }}</a></li>
<li class="divider"></li>
<li><a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.logout') }}">{{ trans('vendirun::standard.logout') }}</a></li>