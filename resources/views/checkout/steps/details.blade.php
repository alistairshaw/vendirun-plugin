<div class="shipping">
    <div class="form-group">
        <label for="emailAddress">Your Email Address</label>
        <input type="email" class="form-control" name="emailAddress" id="emailAddress" value="{{ $customer ? $customer->primary_email : '' }}">
    </div>
    <div class="form-group form-inline clearfix">
        <div class="form-group">
            <label for="title">Title</label><br>
            <select class="form-control" name="title" id="title">
                @foreach ($titles as $title)
                    <option value="{{ $title->id }}">{{ $title->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group pull-right">
            <label>
                <input type="checkbox" name="company" id="company" value="1"{{ $customer && $customer->organisation_name ? ' checked' : '' }}>
                {{ trans('vendirun::checkout.companyPurchase') }}
            </label>
        </div>
    </div>
    <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" class="form-control" name="fullName" id="fullName" value="{{ $customer ? $customer->first_name . ' ' . $customer->last_name : '' }}">
    </div>
    <div class="form-group">
        <label for="companyName">Company Name</label>
        <input type="text" class="form-control" name="companyName" id="companyName" value="{{ $customer ? $customer->organisation_name : '' }}">
    </div>
    @if ($customer)
        @include('vendirun::customer.partials.address-form', ['selected' => $customer->primary_address->id, 'prefix' => 'shipping'])
    @else
        @include('vendirun::customer.partials.address-form', ['prefix' => 'shipping'])
    @endif
</div>