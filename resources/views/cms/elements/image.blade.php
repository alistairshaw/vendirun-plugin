<div class="vr-image-element">
    @if ($element->url)
        <a href="{{ $element->url }}">
            @endif
            <img src="{{ $element->content }}" alt="{{ $element->alt }}" {{ $element->height > 0 ? 'style="height: ' . $element->height . 'px; width: ' . $element->width . 'px;"' : '' }} class="img-responsive">
            @if ($element->caption)
                <div class="caption">
                    {{ $element->caption }}
                </div>
            @endif
            @if ($element->url)
        </a>
    @endif
</div>