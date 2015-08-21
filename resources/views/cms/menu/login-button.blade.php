@if (Session::has('token'))
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{{ $loggedInName }}} <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ route('vendirun.logout') }}">Logout</a></li>
        </ul>
    </li>
@else
    <li><a href="{{ route('vendirun.register') }}">Login</a></li>
@endif