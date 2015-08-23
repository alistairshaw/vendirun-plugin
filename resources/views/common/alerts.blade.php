<div class="container">
    @if (Session::has('vendirun-alert-success'))
        <div class="alert alert-success js-fade-out" data-time="10">
            <i class="fa fa-check"></i> {!! Session::get('vendirun-alert-success') !!}
        </div>
    @endif

    @if (Session::has('vendirun-alert-info'))
        <div class="alert alert-info js-fade-out" data-time="10">
            <i class="fa fa-info"></i> {!! Session::get('vendirun-alert-info') !!}
        </div>
    @endif

    @if (Session::has('vendirun-alert-error'))
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle"></i> {!! Session::get('vendirun-alert-error') !!}
        </div>
    @endif
</div>