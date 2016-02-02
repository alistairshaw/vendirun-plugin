@extends('vendirun::layouts.standard')
@section('title', 'Blog')
@section('body-class', 'blog-posts')
@section('content')
    <div class="container blog-list">
        <h1>Blog</h1>
        @foreach($posts->result as $post)
            <div class="blog-entry">
                <div class="row">
                    <div class="col-sm-3">
                        <a href="/blog/{{ $post->slug }}"><img src="{{ $post->main_image_url . '/thumbnail-sq' }}" class="img-responsive"></a>
                    </div>
                    <div class="col-sm-9">
                        <h2><a href="/blog/{{ $post->slug }}">{{ $post->title }}</a></h2>
                        <p>{{ $post->excerpt }}</p>
                        <p><a href="/blog/{{ $post->slug }}">Read More</a></p>
                        <div class="author">By <a href="/blog/search/?author={{ $post->author }}">{{ $post->author }}</a></div>
                        <div class="created">{{ date("jS M, Y", strtotime($post->created)) }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop