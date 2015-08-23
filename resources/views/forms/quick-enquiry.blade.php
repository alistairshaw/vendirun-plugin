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
                {!! Form::label('fullname', 'Full Name') !!}
                {!! Form::text('fullname', '', array('placeholder'=>'Full Name', 'class'=>'form-control')) !!}
                @if ($errors->has('fullname')) <p class="help-block">{{ $errors->first('fullname') }}</p> @endif
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email Address') !!}
                {!! Form::text('email', '', array('placeholder'=>'Email Address', 'class'=>'form-control')) !!}
                @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
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