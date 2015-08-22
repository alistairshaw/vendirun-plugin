<!DOCTYPE html>
<head>
    @include('vendirun::common.head')
</head>
<html>
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
<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>