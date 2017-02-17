@if ($slider == false)
    <code>Invalid slider on page. Try removing the slider and re-adding it.</code>
@else
    <div class="vendirun-slider-widget {{ $slider['css'] }}">
        <div class="carousel-container" style="{{ implode("; ", $slider['sliderStyles']) }}">
            <div id="vendirun-carousel-{{ $slider['id'] }}" class="carousel slide" data-ride="carousel"
                 data-interval="{{ $slider['speed'] }}">
                @if (count($slider['slides']) > 1)
                    <ol class="carousel-indicators">
                        <?php $counter = 0; ?>
                        @foreach ($slider['slides'] as $slide)
                            <li data-target="#vendirun-carousel-{{ $slider['id'] }}"
                                data-slide-to="<?php echo $counter ?>"<?php if ($counter == 0) echo ' class="active"'; ?>></li>
                            <?php $counter++; ?>
                        @endforeach
                    </ol>
                @endif

                <div class="carousel-inner" role="listbox">
                    <?php $index = 0; ?>
                    @foreach ($slider['slides'] as $slide)
                        <a href="{{ $slide['link'] }}" class="item<?php if ($index == 0) echo ' active'; ?>"
                           style="{{ implode("; ", $slide['slideStyles']) }}">
                            @if (!$slide['setAsBackground'])
                            <img src="{{ asset($slide['background']->hd) }}">
                            @endif
                            @if ($slide['caption'])
                                <div class="carousel-caption">
                                    {{ $slide['caption'] }}
                                </div>
                            @endif
                            @if ($slide['content'])
                                @include('vendirun::cms.widgets.slider-content')
                            @endif
                            @if ($slide['callToAction'])
                                @include('vendirun::cms.widgets.slider-call-to-action')
                            @endif
                        </a>
                        <?php $index++; ?>
                    @endforeach

                    @if (count($slider['slides']) > 1)
                        <a class="left carousel-control" href="#vendirun-carousel-{{ $slider['id'] }}" role="button"
                           data-slide="prev">
                            <span class="fa fa-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#vendirun-carousel-{{ $slider['id'] }}" role="button"
                           data-slide="next">
                            <span class="fa fa-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif