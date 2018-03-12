<form method="POST" action="{{ route('vendirun.contactFormSubmit') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    @if (isset($property))
        <input type="hidden" name="property" value="{{ $property->reference . ' - ' . $property->title }}">
        <input type="hidden" name="propertyId" value="{{ $property->id }}">
    @endif

    @if (isset($productDisplay))
        <input type="hidden" name="product" value="{{ $productDisplay['productName'] }}">
        <input type="hidden" name="productId" value="{{ $productDisplay['id'] }}">
    @endif

    <input type="hidden" name="formId" value="Quick Enquiry">
    <div class="well js-contact-us" id="contact-us">
        <div class="row">
            <div class="col-sm-12">
                <h3>{{ trans('vendirun::forms.quickEnquiry') }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                @if(Session::has('alert_message'))
                    <div class="alert-box success">
                        <p>{{ Session::get('alert_message') }}</p>
                    </div>
                @endif
                <div class="form-group">
                    <label for="fullname">{{ trans('vendirun::forms.fullName') }}</label>
                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="{{ trans('vendirun::forms.fullName') }}">
                </div>
                <div class="form-group">
                    <label for="email">{{ trans('vendirun::forms.email') }}</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="{{ trans('vendirun::forms.email') }}">
                </div>
                <div class="form-group">
                    <label for="telephone">{{ trans('vendirun::forms.telephone') }}</label>
                    <input type="text" class="form-control" name="telephone" id="telephone" placeholder="{{ trans('vendirun::forms.telephone') }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="message">{{ trans('vendirun::forms.message') }}</label>
                    <textarea class="form-control" name="message" id="message" rows="6" placeholder="{{ trans('vendirun::forms.message') }}"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ trans('vendirun::forms.sendMessage') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>