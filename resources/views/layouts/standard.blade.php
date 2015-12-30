<!DOCTYPE html>
<head>
    @include('vendirun::common.head')
</head>
<html>
<body class="@yield('body-class')">
<header id="header" class="clearfix cl-header">
    @include('vendirun::common.header')
</header>
@include('vendirun::common.alerts')
<div id="fb-root"></div>
<section id="main" role="main" class="clearfix">
    @yield('content')
    <footer id="footer">
        @include('vendirun::common.footer')
    </footer>
</section>
<script src="{{ asset('vendor/vendirun/js/production.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&callback=initializeMap" async defer></script>
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
</script>
</body>

</html>