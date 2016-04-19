@extends('vendirun::layouts.standard')
@section('title', 'Blog')
@section('body-class', 'blog-posts')
@section('content')
    <div class="container">
        <h1>Blog</h1>
        @include('vendirun:blog.posts')
    </div>
@stop