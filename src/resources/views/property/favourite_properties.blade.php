@extends('...layouts.standard')
@section('content')

    <div class="container-fluid clearfix">
        <div class="row search-height">
            <div class="col-sm-10 col-sm-offset-1 js-main-results">
                <div class="property-results">
                    <h2 class="page-header">Favourited Properties</h2>
                    @if(isset($property->result))
                        @forelse ($property->result as $property)

                            @include('vendirun::property.result', array('property'=>$property, 'pageLocation' => 'fav'))

                        @empty
                            <p> No Properties were found click <a href="{{ route('vendirun.propertySearch') }}">here</a> to return to property page. </p>
                        @endforelse
                    @else
                        <p> No Properties were found click <a href="{{ route('vendirun.propertySearch') }}">here</a> to search!. </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop