@if (isset($staff))
    <div class="staff">
        <div class="row">
            @foreach($staff as $person)
                <div class="col-sm-3">
                    <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.staff',[$person->id, urlencode($person->first_name)]) }}" class="staff-item">
                        <div class="photo">
                            @foreach (array_slice($person->images, 0, 1) as $image)
                                <img src="{{ $image->mediumsq }}" class="img-responsive img-circle">
                            @endforeach
                        </div>
                        <div class="name">{{ $person->first_name . ' ' . $person->last_name }}</div>
                        <div class="job-title">{{ $person->website_job_title }}</div>
                        <div class="excerpt">{{ $person->website_excerpt }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif