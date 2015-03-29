@if(!Session::get('token'))
    <a href="{{ route('vendirun.register') }}"><i class="fa fa-user"></i> Login</a>
@else
    <a href="{{ route('vendirun.viewFavouriteProperties') }}"><i class="fa fa-star"></i> View Favourite</a>
    <a href="{{ route('vendirun.logout') }}"><i class="fa fa-user"></i> Logout</a>
@endif