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
            <a class="navbar-brand" href="{{ route(LocaleHelper::localePrefix() . 'vendirun.home') }}">
                @include('vendirun::common.logo')
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                @include('vendirun::cms.menu')
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @include('vendirun::cms.menu.login-button')
                @include('vendirun::product.partials.cart.cart-widget')
                @if(count(\AlistairShaw\Vendirun\App\Lib\ClientHelper::getClientInfo()->additional_languages))
                    <li>
                        @include('vendirun::common.language-select')
                    </li>
                @endif
            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>