@if(!Session::get('token'))
    <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.register') }}"><i class="fa fa-user"></i> {{ trans('vendirun::standard.login') }}</a>
@else
    <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.viewFavouriteProperties') }}"><i class="fa fa-star"></i> {{ trans('vendirun::property.favourites') }}e</a>
    <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.logout') }}"><i class="fa fa-user"></i> {{ trans('vendirun::forms.logout') }}</a>
@endif