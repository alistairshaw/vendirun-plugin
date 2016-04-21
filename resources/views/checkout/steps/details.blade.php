<div class="shipping">
    <div class="form-group">
        <label for="emailAddress">Your Email Address</label>
        <input type="email" class="form-control" name="emailAddress" id="emailAddress" value="{{ $customer ? $customer->getPrimaryEmail() : old('emailAddress', '') }}" required>
    </div>
    <div class="form-group form-inline clearfix">
        <div class="form-group">
            <label>
                <input type="checkbox" name="company" id="company" value="1"{{ $customer && $customer->getCompanyName() ? ' checked' : old('company') ? ' checked' : '' }}>
                {{ trans('vendirun::checkout.companyPurchase') }}
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" class="form-control" name="fullName" id="fullName" value="{{ $customer ? $customer->fullName() : old('fullName', '') }}" required>
    </div>
    <div class="form-group js-company-name-field">
        <label for="companyName">Company Name</label>
        <input type="text" class="form-control" name="companyName" id="companyName" value="{{ $customer ? $customer->getCompanyName() : old('companyName', '') }}">
    </div>
    @if ($customer)
        @include('vendirun::customer.partials.address-select', ['selected' => $defaultAddress->getId(), 'prefix' => 'shipping'])
    @else
        @include('vendirun::customer.partials.address-form', ['prefix' => 'shipping'])
    @endif
</div>