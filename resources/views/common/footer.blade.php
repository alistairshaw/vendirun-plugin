<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <h3>{{ $clientData->name }}</h3>
            <p>{{ $clientData->address . ' ' . $clientData->post_code }}</p>
        </div>
        <div class="col-sm-3">
            <h3>{{ trans('vendirun::standard.contactUs') }}</h3>
            <p>
                t: {{ $clientData->telephone }}<br>
                e: {{ $clientData->email }}
            </p>
        </div>
        <div class="col-sm-3">
            <h3>{{ trans('vendirun::standard.officeHours') }}</h3>
            <p>
                {{ trans('vendirun::standard.actualOfficeHours1') }}<br>
                {{ trans('vendirun::standard.actualOfficeHours2') }}<br>
                {{ trans('vendirun::standard.actualOfficeHours3') }}
            </p>
        </div>
        <div class="col-sm-3">
            <h3>{{ trans('vendirun::standard.followUs') }}</h3>
            @include('vendirun::cms.widgets.standard-social')
        </div>
    </div>
</div>