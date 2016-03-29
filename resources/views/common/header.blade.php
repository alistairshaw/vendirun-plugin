<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">{{ trans('vendirun::standard.toggleNavigation') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.home') }}">
                @include('vendirun::common.logo')
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ trans('vendirun::standard.customer') }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.register') }}">{{ trans('vendirun::standard.loginOrRegister') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.logout') }}">{{ trans('vendirun::standard.logout') }}</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ trans('vendirun::property.property') }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertySearch') }}">{{ trans('vendirun::property.listings') }}</a></li>
                        <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.searchProperties') }}">{{ trans('vendirun::property.search') }}</a></li>
                        <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.location') }}">{{ trans('vendirun::property.locations') }}</a></li>
                        <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category') }}">{{ trans('vendirun::property.categories') }}</a></li>
                        @if (Session::has('token'))
                            <li class="divider"></li>
                            <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.viewFavouriteProperties') }}">{{ trans('vendirun::property.favourites') }}</a></li>
                        @endif
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ trans('vendirun::product.products') }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productSearch') }}">{{ trans('vendirun::product.browse') }}</a></li>
                    </ul>
                </li>

                <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.blog') }}">Blog</a></li>

                <li><a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.menu') }}">Menu</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @include('vendirun::cms.menu.login-button')
                <li>
                    @include('vendirun::common.language-select')
                </li>
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>