<div class="address-form {{ $prefix }}-address-form js-{{ $prefix }}-address-form">
    <div class="form-group">
        <label for="{{ $prefix }}address1">{{ trans('vendirun::forms.address1') }}</label>
        <input type="text" class="form-control" name="{{ $prefix }}address1" id="{{ $prefix }}address1" value="{{ old($prefix . 'address1', $address['address1']) }}">
    </div>
    <div class="form-group">
        <label for="{{ $prefix }}address2">{{ trans('vendirun::forms.address2') }}</label>
        <input type="text" class="form-control" name="{{ $prefix }}address2" id="{{ $prefix }}address2" value="{{ old($prefix . 'address2', $address['address2']) }}">
    </div>
    <div class="form-group">
        <label for="{{ $prefix }}address3">{{ trans('vendirun::forms.address3') }}</label>
        <input type="text" class="form-control" name="{{ $prefix }}address3" id="{{ $prefix }}address3" value="{{ old($prefix . 'address3', $address['address3']) }}">
    </div>
    <div class="form-group">
        <label for="{{ $prefix }}city">{{ trans('vendirun::forms.city') }}</label>
        <input type="text" class="form-control" name="{{ $prefix }}city" id="{{ $prefix }}city" value="{{ old($prefix . 'city', $address['city']) }}">
    </div>
    <div class="form-group">
        <label for="{{ $prefix }}state">{{ trans('vendirun::forms.state') }}</label>
        <input type="text" class="form-control" name="{{ $prefix }}state" id="{{ $prefix }}state" value="{{ old($prefix . 'state', $address['state']) }}">
    </div>
    <div class="form-group">
        <label for="{{ $prefix }}postcode">{{ trans('vendirun::forms.postcode') }}</label>
        <input type="text" class="form-control" name="{{ $prefix }}postcode" id="{{ $prefix }}postcode" value="{{ old($prefix . 'postcode', $address['postcode']) }}">
    </div>
    <div class="form-group">
        <label for="{{ $prefix }}countryId">{{ trans('vendirun::forms.country') }}</label>
        @include('vendirun::customer.partials.country-select', ['fieldId' => $prefix . 'countryId', 'fieldName' => $prefix . 'countryId'])
    </div>
</div>