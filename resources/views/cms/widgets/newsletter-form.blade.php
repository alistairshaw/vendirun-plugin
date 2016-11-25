<?php if (!isset($options)) $options = json_decode($element->element_options, true) ?>
<div class="well contact-form">
    <form method="post" action="{{ route('vendirun.contactFormSubmit') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="formId" value="Newsletter Signup">
        <h3>{{ trans('vendirun::forms.newsletterSignUp') }}</h3>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="contact_fullname">{{ $options['fullname_label'] or trans('vendirun::forms.fullName') }}</label>
                    <input type="text" class="form-control" name="fullname" id="contact_fullname" value="" placeholder="{{ $options['fullname_place_holder'] or '' }}" {{ (isset($options['fullname_required'])) ? 'required' : '' }}>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="contact_email">{{ $options['email_label'] or trans('vendirun::forms.email') }}</label>
                    <input type="email" class="form-control" name="email" id="contact_email" value="" placeholder="{{ $options['email_place_holder'] or '' }}" {{ (isset($options['email_required'])) ? 'required' : '' }}>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ trans('vendirun::forms.newsletterSubmit') }}</button>
    </form>
</div>