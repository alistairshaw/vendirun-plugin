@extends('vendirun::layouts.standard')
@section('title', $page->title)
@section('description', $page->meta_description)
@section('keywords', $page->meta_keywords)
@section('body-class', 'cms-page cms-page-' . str_replace('/', '-', $page->slug ? $page->slug : 'home'))
@section('content')
    @foreach ($page->page_blocks as $block)
        <div class="vendirun-cms-block {{ $block->class }}">
            <div class="container{{ $block->full_width ? '-fluid' : '' }} vr-cms-content">
                <div class="row">
                    <div class="clearfix" style="margin: {{ $block->margin }}; padding: {{ $block->padding }};">
                        @foreach ($block->elements as $element)
                            <div class="{{ $block->full_width ? '' : 'col-sm-' . $element->column_width }} {{ $element->class }}">
                                <?php try { ?>
                                @include('vendirun::cms.elements.' . $element->type)
                                <?php } catch (Exception $e) { echo '<code style="text-align: center; padding: 50px; display: block;" class="alert alert-info"><i class="fa fa-question-circle"></i> Empty Block</code>'; } ?>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@stop