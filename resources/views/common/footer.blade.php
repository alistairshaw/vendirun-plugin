<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <h3>{{ $clientData->name }}</h3>
            <p>{{ $clientData->address . ' ' . $clientData->post_code }}</p>
        </div>
        <div class="col-sm-3">
            <h3>Contact Us</h3>
            <p>
                t: {{ $clientData->telephone }}<br>
                e: {{ $clientData->email }}
            </p>
        </div>
        <div class="col-sm-3">
            <h3>Office Hours</h3>
            <p>Mon - Fri 10:00 - 20:00<br>Saturday 10:00 - 18:00</p>
        </div>
        <div class="col-sm-3">
            <h3>Follow Us</h3>
            @include('vendirun::cms.widgets.standard-social', [
                'options' => [
                    'social_type' => 'light',
                    'social_facebook' => '#',
                    'social_twitter' => '#',
                    'social_googleplus' => '#',
                    'social_rss' => '#'
                ]]
            )
        </div>
    </div>
</div>