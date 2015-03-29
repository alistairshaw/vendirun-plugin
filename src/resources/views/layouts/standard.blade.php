<!DOCTYPE html>
<head>
    @include('vendirun::common.head')
</head>

<body>
<header id="header" class="clearfix cl-header">
    @include('vendirun::common.header')
</header>
<section id="main" role="main" class="clearfix">
    @yield('content')
    <footer id="footer">
        @include('vendirun::common.footer')
    </footer>
</section>
</body>

</html>

<script src="{{ asset('js/production.js') }}"></script>