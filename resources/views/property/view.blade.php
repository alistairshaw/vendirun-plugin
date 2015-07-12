@extends('vendirun::layouts.standard')

@section('content')

    <div class="container property-view js-single-property">
        <div class="row">
            <div class="col-sm-12">
                @if(Session::has('alert_message_recommend_a_friend'))
                    <div class="alert-box success">
                        <p>{{ Session::get('alert_message_recommend_a_friend') }}</p>
                    </div>
                @endif
                <div class="image-container img-thumbnail" style="margin-top: 20px;">
                    <ul class="property-slide-show">
                        @forelse($property->images as $images)
                            <li><a class="fancybox" rel="group" href="{{ $images->largerect }}"><img src="{{ $images->largerect }}" alt=""/></a></li>
                        @empty

                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="well description-well">
                    <div class="price">€{{ $property->price }}</div>
                    <h1>{{ $property->title }}</h1>
                    {!! $property->short_description !!}
                </div>
            </div>
        </div>


        <div class="image-container thumbnails">
            <div class="row">
                @forelse($property->images as $images)
                    <div class="col-sm-3">
                        <a href="{{ $images->large }}" data-lightbox="image-1" data-title="Images"><img src="{{ $images->mediumsq }}" class="img-responsive img-thumbnail"></a>
                    </div>
                @empty

                @endforelse
            </div>
        </div>

        <div class="well amenities-well">
            <div class="row">
                <div class="col-sm-12">
                    <div class="amenities">
                        @forelse($property->attributes as $row)
                            <label class="label label-primary">{{ $row->property_attribute_name }}</label>
                        @empty

                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="well">
            <div class="buttons">
                @if (isset($favouriteProperties) && in_array($property->id, $favouriteProperties))
                    <a href="{{ route('vendirun.propertyRemoveFav', $property->id) }}" class="btn btn-default"><i class="fa fa-remove"></i> Remove From Favourites</a>
                @endif
                <a href="{{ (in_array($property->id, $favouriteProperties)) ? route('vendirun.viewFavouriteProperties') : route('vendirun.propertyAddToFav',$property->id) }}" class="btn btn-default"><i class="fa {{ in_array($property->id, $favouriteProperties) ? 'fa-check' : 'fa-star' }}"></i>{{ in_array($property->id, $favouriteProperties) ?  ' View Favourites' : ' Add to Favorites' }}
                </a>
                <button type="button" data-property-name="{{ $property->title }}" data-property-id="{{ $property->id }}" data-toggle="modal" data-target="#recommendAFriend" class="btn btn-default js-request-request-to-friend"><i class="fa fa-user"></i> Send to a Friend</button>
                <a href="{{ route('vendirun.propertyView',$property->id) }}#contact-us" class="btn btn-default js-contact-us-btn"><i class="fa fa-envelope"></i> Contact Us</a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="well description-well">
                    {!! $property->long_description !!}
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Town</th>
                            <td>{{ $property->city }}</td>
                            <th>Location</th>
                            <td>{{ $property->location_name }}</td>
                        </tr>
                        <tr>
                            <th>Beds</th>
                            <td>{{ $property->bedrooms }}</td>
                            <th>Baths</th>
                            <td>{{ $property->bathrooms }}</td>
                        </tr>
                        <tr>
                            <th>Main Build</th>
                            <td>{{ $property->build_size }}m<sup>2</sup></td>
                            <th>Main Terrace</th>
                            <td>{{ $property->terrace_size }} m<sup>2</sup></td>
                        </tr>
                        <tr>
                            <th>Main Garden</th>
                            <td>{{ $property->garden_size }}m<sup>2</sup></td>
                            <th>Plot</th>
                            <td>{{ $property->total_plot_size }}m<sup>2</sup></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($property->lat && $property->lng)
            <input type="hidden" id="propertyLat" value="{{ $property->lat }}">
            <input type="hidden" id="propertyLng" value="{{ $property->lng }}">
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
            <div class="well">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="map-canvas"></div>
                    </div>
                </div>
            </div>
        @endif

        @include('vendirun::forms.quick-enquiry')
    </div>
    @include('vendirun::forms.recommend-a-friend')

@stop