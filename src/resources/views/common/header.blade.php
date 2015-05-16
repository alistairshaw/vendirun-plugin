<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('vendirun.propertySearch') }}">Vendirun</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Customer <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('vendirun.register') }}">Login / Register</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('vendirun.logout') }}">Logout</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Property <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('vendirun.propertySearch') }}">Listings</a></li>
                        <li><a href="#">Search</a></li>
                        <li><a href="#">Locations</a></li>
                        <li><a href="#">Categories</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->

        <div class="pull-right">
            @if (Session::has('token'))
                {{{ $loggedInName }}}<br>
                {{{ $loggedInEmail }}}
            @else
                <a href="{{ route('vendirun.register') }}">Login</a>
            @endif
        </div>
    </div><!-- /.container-fluid -->
</nav>