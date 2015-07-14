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
@endif

@if ($element_options['layout'] == '2 columns' || $element_options['layout'] == '3 columns' || $element_options['layout'] == '4 columns')
    <div class="row">
        @foreach($location->sub_locations as $subLocation)
            <div class="col-sm-6 col-md-{{ $element_options['col_md'] }}">
                <div class="thumbnail">
                    @if ($element_options['show_images'] == 'Yes')
                        <a href="{{ route('vendirun.location', [urlencode($subLocation->location_name)]) }}">
                            <img src="{{ reset($subLocation->images)->mediumrect }}" class="img-responsive">
                        </a>
                    @endif

                    <div class="caption">
                        <h3 id="thumbnail-label">{{ $subLocation->location_name }}</h3>

                        <p>{{ substr($subLocation->location_description, 0, 300) }}{{ (strlen($subLocation->location_description) > 300) ? '...' : '' }}</p>

                        <form method="post" action="{{ route('vendirun.propertySearch') }}">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <input type="hidden" class="form-control" value="{{ $subLocation->location_name }}" name="location">
                            <button type="submit" class="btn btn-default">View Properties</button>
                            <a class="btn btn-primary" href="{{ route('vendirun.location', [urlencode($subLocation->location_name)]) }}">View Location</a>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@elseif ($element_options['layout'] == 'Staggered')
    <div class="property-categories">
        <div class="row">
            <?php  $count = 0; ?>
            @foreach($location->sub_locations as $subLocation)
                <?php $count++;?>
                @if($count > 2)
                    <?php if ($count == 4) $count = 0; ?>
                    <div class="col-sm-6 clearfix">
                        <div class="category-search-item">
                            <div class="col text-col-left">
                                <div class="arrow arrow-right">
                                    <i class="fa fa-caret-right fa-4x"></i>
                                </div>
                                <div class="copy">
                                    <h2>{{ $subLocation->location_name }}</h2>

                                    <p>{{ $subLocation->location_description }}</p>

                                    <form method="post" action="{{ route('vendirun.propertySearch') }}">
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <input type="hidden" class="form-control" value="{{ $subLocation->id }}" name="location">
                                        <button type="submit" class="btn btn-default">View Properties</button>
                                        <a class="btn btn-primary" href="{{ route('vendirun.location', [urlencode($subLocation->location_name)]) }}">View Location</a>
                                    </form>
                                </div>
                            </div>
                            <div class="col col-right">
                                <a href="{{ route('vendirun.location', [urlencode($subLocation->location_name)]) }}">
                                    <img src="{{ reset($subLocation->images)->mediumsq }}" class="img-responsive">
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-6 clearfix">
                        <div class="category-search-item">
                            <div class="col">
                                <a href="{{ route('vendirun.location', [urlencode($subLocation->location_name)]) }}">
                                    <img src="{{ reset($subLocation->images)->mediumsq }}" class="img-responsive">
                                </a>
                            </div>
                            <div class="col text-col">
                                <div class="arrow arrow-left">
                                    <i class="fa fa-caret-left fa-4x"></i>
                                </div>
                                <div class="copy">
                                    <h2>{{ $subLocation->location_name }}</h2>

                                    <p>{{ $subLocation->location_description }}</p>

                                    <form method="post" action="{{ route('vendirun.propertySearch') }}">
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}}">
                                        <input type="hidden" class="form-control" value="{{ $subLocation->id }}" name="location">
                                        <button type="submit" class="btn btn-default">View Properties</button>
                                        <a class="btn btn-primary" href="{{ route('vendirun.location', [urlencode($subLocation->location_name)]) }}">View Location</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@else
    <div class="property-categories">
        @foreach($location->sub_locations as $subLocation)
            <div class="property-category-list-item clearfix">
                @if ($element_options['show_images'] == 'Yes')
                    <div class="image-container">
                        <a href="{{ route('vendirun.location', [urlencode($subLocation->location_name)]) }}">
                            <img src="{{ reset($subLocation->images)->mediumrect }}" class="img-responsive">
                        </a>
                    </div>
                @endif
                <div class="details">
                    <h2>{{ $subLocation->location_name }}</h2>

                    <p>{{ $subLocation->location_description }}</p>

                    <div class="buttons">
                        <form method="post" action="{{ route('vendirun.propertySearch') }}">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}}">
                            <input type="hidden" class="form-control" value="{{ $subLocation->id }}" name="location">
                            <button type="submit" class="btn btn-default">View Properties</button>
                            <a class="btn btn-primary" href="{{ route('vendirun.location', [urlencode($subLocation->location_name)]) }}">View Location</a>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif