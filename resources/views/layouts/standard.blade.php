<!DOCTYPE html>
<head>
    @include('vendirun::common.head')
</head>

<body>
<header id="header" class="clearfix cl-header">
    @include('vendirun::common.header')
</header>
@include('vendirun::common.alerts')
<section id="main" role="main" class="clearfix">
    @yield('content')
    <footer id="footer">
        @include('vendirun::common.footer')
    </footer>
</section>
</body>

</html>

<script src="{{ asset('vendor/vendirun/js/production.js') }}"></script>