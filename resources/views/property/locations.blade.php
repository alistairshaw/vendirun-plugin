@extends('vendirun::layouts.standard')
@section('content')
    <div class="container clearfix">

        <h2 class="page-header">
            @if(isset($backButton))
                <a role="button" class="btn btn-primary pull-right" href="{{ route('vendirun.location', $backButton) }}"><i class="fa fa-chevron-left"></i> Back</a>
            @endif
            {{ (isset($locationData->master_location->location_name)  && $locationData->master_location->location_name != '') ?  $locationData->master_location->location_name : 'Locations' }}
        </h2>
        @if(isset($locationData->master_location) && count($locationData->master_location) > 0)
            <div class="row">
                <div class="col-sm-4">
                    <div class="image-container img-thumbnail">
                        <div class="property-slide-show">
                            @forelse($locationData->master_location->images as $image)
                                <img src="{{ $image }}" title="" alt="">
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4>{{ $locationData->master_location->location_name }}</h4>
                    <p>{{ $locationData->master_location->location_description }}</p>
                    <a role="button" class="btn btn-primary" href="{{ route('vendirun.location', [urlencode($locationData->master_location->location_name), $locationData->master_location->id]) }}">View properties</a></p>
                </div>
            </div>
            <hr>
        @endif
        <div class="row">
            @foreach($locationData->locations as $location)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{ $location->images[0] }}">
                        <div class="caption">
                            <h3 id="thumbnail-label">{{ $location->location_name }}</h3>
                            <p>{{ substr($location->location_description, 0, 300) }}{{ (strlen($location->location_description) > 300) ? '...' : '' }}</p>
                            <form method="post" action="{{ route('vendirun.propertySearch') }}">
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                                <input type="hidden" class="form-control" value="{{ $location->location_name }}" name="location">
                                <button type="submit" class="btn btn-default">View Properties</button>
                                <a class="btn btn-primary" href="{{ route('vendirun.location', [urlencode($location->location_name), $location->id]) }}">View Location</a>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop