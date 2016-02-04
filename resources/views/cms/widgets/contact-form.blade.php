<?php if (!isset($options)) $options = json_decode($element->element_options, true) ?>
<div class="well contact-form">
    @if ($options['form_title'])
        <h3>{{ $options['form_title'] }}</h3>
    @endif
    @if ($options['form_description'])
        <p>{{ $options['form_description'] }}</p>
    @endif
    {!! Form::open(['route' => 'vendirun.contactFormSubmit']) !!}
    {!! Form::hidden('formId', $options['form_title']) !!}
    <div class="row">
        <div class="col-sm-6">
            @if (isset($options['fullname']))
                <div class="form-group">
                    <label for="contact_fullname">{{ $options['fullname_label'] or trans('vendirun::forms.fullName') }}</label>
                    <input type="text" class="form-control" name="fullname" id="contact_fullname" value="" placeholder="{{ $options['fullname_place_holder'] or '' }}" {{ (isset($options['fullname_required'])) ? 'required' : '' }}>
                </div>
            @endif
            @if (isset($options['email']))
                <div class="form-group">
                    <label for="contact_email">{{ $options['email_label'] or trans('vendirun::forms.email') }}</label>
                    <input type="email" class="form-control" name="email" id="contact_email" value="" placeholder="{{ $options['email_place_holder'] or '' }}" {{ (isset($options['email_required'])) ? 'required' : '' }}>
                </div>
            @endif
            @if (isset($options['telephone']))
                <div class="form-group">
                    <label for="contact_telephone">{{ $options['telephone_label'] or trans('vendirun::forms.telephone') }}</label>
                    <input type="text" class="form-control" name="telephone" id="contact_telephone" value="" placeholder="{{ $options['telephone_place_holder'] or '' }}" {{ (isset($options['telephone_required'])) ? 'required' : '' }}>
                </div>
            @endif
        </div>
        <div class="col-sm-6">
            @if (isset($options['message']))
                <div class="form-group">
                    <label for="contact_message">{{ $options['message_label'] or trans('vendirun::forms.telephone') }}</label>
                    <textarea class="form-control" rows="6" name="message" id="contact_message" placeholder="{{ $options['message_place_holder'] or '' }}" {{ (isset($options['message_required'])) ? 'required' : '' }}></textarea>
                </div>
            @endif
            <button type="submit" class="btn btn-primary">{{ $options['form_button'] or trans('vendirun::forms.submit') }}</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>