<div class="container">
    @if ($alert = Session::get('vendirun-alert-success'))
        <div class="alert alert-success js-fade-out" data-time="10">
            <i class="fa fa-check"></i> {{ $alert }}
        </div>
    @endif

    @if ($alert = Session::get('vendirun-alert-info'))
        <div class="alert alert-info js-fade-out" data-time="10">
            <i class="fa fa-info"></i> {{ $alert }}
        </div>
    @endif

    @if ($alert = Session::get('vendirun-alert-error'))
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle"></i> {{ $alert  }}
        </div>
    @endif
</div>