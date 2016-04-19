@extends('vendirun::layouts.standard')
@section('content')
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">{{ trans('vendirun::standard.toggleNavigation') }}</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route(LocaleHelper::localePrefix() . 'vendirun.home') }}">Vendirun</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @include('vendirun::cms.menu')
                </ul>
            </div>
        </div>
    </nav>
@stop