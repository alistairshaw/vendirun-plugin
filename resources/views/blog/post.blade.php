@extends('vendirun::layouts.standard')
@section('title', $post->title)
@section('description', $post->meta_description)
@section('keywords', $post->meta_keywords)
@section('body-class', 'vendirun-app blog-post ' . str_replace('/', '-', $post->slug ? 'blog-post-' . $post->slug : ''))
@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <div class="tags">
            <div class="author">By <a href="/blog/search/?author={{ $post->author }}">{{ $post->author }}</a></div>
            <div class="created">{{ date("jS M, Y", strtotime($post->created)) }}</div>
        </div>
        {!! $post->content !!}
    </div>
@stop