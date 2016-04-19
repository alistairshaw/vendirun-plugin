<div class="blog-list">
    @foreach($posts->result as $post)
        <div class="blog-entry">
            <div class="blog-entry-container">
                <div class="image-container{{ isset($hideImages) && $hideImages ? ' hidden' : '' }}">
                    <a href="/blog/{{ $post->slug }}"><img src="{{ $post->main_image_url . '/medium-sq' }}" class="img-responsive"></a>
                </div>
                <div class="blog-item-container">
                    <h2><a href="/blog/{{ $post->slug }}">{{ $post->title }}</a></h2>
                    <p>{{ $post->excerpt }}</p>
                    <p><a href="/blog/{{ $post->slug }}">Read More</a></p>
                    <div class="author">By <a href="/blog/search/?author={{ $post->author }}">{{ $post->author }}</a>
                    </div>
                    <div class="created">{{ date("jS M, Y", strtotime($post->created)) }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>