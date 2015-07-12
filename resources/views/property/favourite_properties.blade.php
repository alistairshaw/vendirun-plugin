@extends('vendirun::layouts.standard')
@section('content')
    @include('vendirun::forms.recommend-a-friend')
    <div class="container property-search clearfix">
        <div class="property-results">
            <h2 class="page-header">Favourited Properties</h2>
            @forelse ($property as $item)
                @include('vendirun::property.result', array('property'=>$item, 'pageLocation' => 'fav'))
            @empty
                <p>You don't have any favourite properties yet! Click <a href="{{ route('vendirun.propertySearch') }}">here</a> to explore and find some!.</p>
            @endforelse
        </div>
    </div>
@stop