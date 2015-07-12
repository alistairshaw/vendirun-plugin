@extends('vendirun::layouts.standard')
@section('content')
    @foreach ($page->page_blocks as $block)
        @switch($block->columns)

    @endforeach
@stop