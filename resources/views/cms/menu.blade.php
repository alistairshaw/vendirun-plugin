@extends('vendirun::layouts.standard')
@section('content')
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
                <a class="navbar-brand" href="{{ route('vendirun.home') }}">Vendirun</a>
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
                            <li><a href="{{ route('vendirun.searchProperties') }}">Search</a></li>
                            <li><a href="{{ route('vendirun.location') }}">Locations</a></li>
                            <li><a href="{{ route('vendirun.category') }}">Categories</a></li>
                            @if (Session::has('token'))
                                <li class="divider"></li>
                                <li><a href="{{ route('vendirun.viewFavouriteProperties') }}">Favourites</a></li>
                            @endif
                        </ul>
                    </li>

                    <li><a href="{{ route('vendirun.menu') }}">Menu</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
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
                </ul>

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
@stop