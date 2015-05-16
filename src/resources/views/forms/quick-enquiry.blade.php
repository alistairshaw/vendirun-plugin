{!! Form::open(array('route' => 'vendirun.contactFormSubmit', 'autocomplete' => 'off')) !!}
{!! Form::hidden('property', $property->title) !!}
{!! Form::hidden('propertyId', $property->id) !!}
{!! Form::hidden('formId', 'Contact form from view property page') !!}
<div class="well js-contact-us" id="contact-us">
    <div class="row">
        <div class="col-sm-12">
            <h3>Quick Enquiry Form</h3>
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
                {!! Form::label('fullName', 'Full Name') !!}
                {!! Form::text('fullName', '', array('placeholder'=>'Full Name', 'class'=>'form-control')) !!}
                @if ($errors->has('fullName')) <p class="help-block">{{ $errors->first('fullName') }}</p> @endif
            </div>
            <div class="form-group">
                {!! Form::label('emailAddress', 'Email Address') !!}
                {!! Form::text('emailAddress', '', array('placeholder'=>'Email Address', 'class'=>'form-control')) !!}
                @if ($errors->has('emailAddress')) <p class="help-block">{{ $errors->first('emailAddress') }}</p> @endif
            </div>
            <div class="form-group">
                {!! Form::label('telephone', 'Telephone') !!}
                {!! Form::text('telephone', '', array('placeholder'=>'Telephone', 'class'=>'form-control')) !!}
                @if ($errors->has('telephone')) <p class="help-block">{{ $errors->first('telephone') }}</p> @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('message', 'Message') !!}
                {!! Form::textarea('message', '', array('placeholder'=>'Message', 'class'=>'form-control')) !!}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}