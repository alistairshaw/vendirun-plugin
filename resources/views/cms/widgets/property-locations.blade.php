@if (isset($location->location_name) && $location->location_name)
    <div class="back-button-container">
        <div class="row">
            <div class="col-sm-12">
                @if ($location->parent)
                    <a href="{{ route('vendirun.location', [urlencode($location->parent->location_name)]) }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back to {{ $location->parent->location_name }}
                    </a>
                @else
                    <a href="{{ route('vendirun.location', ['']) }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> Back to Locations</a>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="image-container img-thumbnail">
                <div class="{{ count($location->images) > 1 ? 'property-slide-show' : '' }}">
                    @foreach($location->images as $image)
                        <img src="{{ $image->mediumrect }}" class="img-responsive">
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <h1>{{ $location->location_name }}</h1>

            <p>{{ $location->location_description }}</p>

            <form method="post" action="{{ route('vendirun.propertySearch') }}">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" class="form-control" value="{{ $location->location_name }}" name="location">
                <button type="submit" class="btn btn-default">View Properties in {{ $location->location_name }}</button>
            </form>
        </div>
    </div>
    <hr>
@else
    <h1>Property Locations</h1>
@endif

<div class="row">
    @foreach($location->sub_locations as $sublocation)
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <a href="{{ route('vendirun.location', [urlencode($sublocation->location_name)]) }}">
                    <img src="{{ reset($sublocation->images)->mediumrect }}" class="img-responsive">
                </a>

                <div class="caption">
                    <h3 id="thumbnail-label">{{ $sublocation->location_name }}</h3>

                    <p>{{ substr($sublocation->location_description, 0, 300) }}{{ (strlen($sublocation->location_description) > 300) ? '...' : '' }}</p>

                    <form method="post" action="{{ route('vendirun.propertySearch') }}">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" class="form-control" value="{{ $sublocation->location_name }}" name="location">
                        <button type="submit" class="btn btn-default">View Properties</button>
                        <a class="btn btn-primary" href="{{ route('vendirun.location', [urlencode($sublocation->location_name)]) }}">View Location</a>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>