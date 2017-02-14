<div class="carousel-content carousel-content-slide-{{ $slide['id'] }}">
    @foreach (explode("\n", $slide['content']) as $line)
        <p><span>{{ $line }}</span></p>
    @endforeach
</div>