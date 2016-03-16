@extends('vendirun::layouts.standard')
@section('title', $person->first_name . ' ' . $person->last_name)
@section('description', $person->website_excerpt)
@section('keywords', '')
@section('body-class', 'cms-page cms-staff cms-staff-' . str_replace(['/', ' ', '_'], '-', strtolower($person->first_name)))
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="photo">
                    @foreach (array_slice($person->images, 0, 1) as $image)
                        <img src="{{ $image->mediumsq }}" class="img-responsive img-circle">
                    @endforeach
                </div>
            </div>
            <div class="col-sm-9">
                <h1 class="name">{{ $person->first_name . ' ' . $person->last_name }}</h1>
                <h2 class="job-title">{{ $person->website_job_title }}</h2>
                <div class="excerpt">{{ $person->website_excerpt }}</div>

                <div class="description">{!! $person->website_description !!}</div>
            </div>
        </div>
    </div>
@stop