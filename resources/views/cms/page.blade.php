@extends('vendirun::layouts.standard')
@section('content')
    @foreach ($page->page_blocks as $block)
        <div class="container{{ $block->full_width ? '-fluid' : '' }} {{ $block->class }}">
            <div class="row">
                <div style="margin: {{ $block->margin }}; padding: {{ $block->padding }};">
                    @foreach ($block->elements as $element)
                        <div class="col-sm-{{ $element->column_width }} {{ $element->class }}">
                            @if ($element->type == 'widget')
                                @include('vendirun::cms.widgets.' . $element->content)
                            @elseif ($element->type == 'html')
                                {!! $element->content !!}
                            @elseif ($element->type == 'image')
                                <img src="{{ $element->content }}" <?php if ($element->height > 0) echo 'style="height: ' . $element->height . 'px; width: ' . $element->width . 'px;"' ?> class="img-responsive">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
@stop