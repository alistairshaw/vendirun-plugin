@if(!Session::get('token'))
    <a href="{{ route('vendirun.register') }}"><i class="fa fa-user"></i> {{ trans('vendirun::standard.login') }}</a>
@else
    <a href="{{ route('vendirun.viewFavouriteProperties') }}"><i class="fa fa-star"></i> {{ trans('vendirun::property.favourites') }}e</a>
    <a href="{{ route('vendirun.logout') }}"><i class="fa fa-user"></i> {{ trans('vendirun::forms.logout') }}</a>
@endif