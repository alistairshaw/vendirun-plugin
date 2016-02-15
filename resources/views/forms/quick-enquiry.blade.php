{!! Form::open(array('route' => 'vendirun.contactFormSubmit', 'autocomplete' => 'off')) !!}
{!! Form::hidden('property', $property->title) !!}
{!! Form::hidden('propertyId', $property->id) !!}
{!! Form::hidden('formId', 'Quick Enquiry') !!}
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
                {!! Form::label('fullname', trans('vendirun::forms.fullName')) !!}
                {!! Form::text('fullname', '', array('placeholder'=>trans('vendirun::forms.fullName'), 'class'=>'form-control')) !!}
                @if ($errors->has('fullname')) <p class="help-block">{{ $errors->first('fullname') }}</p> @endif
            </div>
            <div class="form-group">
                {!! Form::label('email', trans('vendirun::forms.email')) !!}
                {!! Form::text('email', '', array('placeholder'=>trans('vendirun::forms.email'), 'class'=>'form-control')) !!}
                @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
            </div>
            <div class="form-group">
                {!! Form::label('telephone', trans('vendirun::forms.telephone')) !!}
                {!! Form::text('telephone', '', array('placeholder'=>trans('vendirun::forms.telephone'), 'class'=>'form-control')) !!}
                @if ($errors->has('telephone')) <p class="help-block">{{ $errors->first('telephone') }}</p> @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('message', trans('vendirun::forms.message')) !!}
                {!! Form::textarea('message', '', array('placeholder'=>trans('vendirun::forms.message'), 'class'=>'form-control')) !!}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ trans('vendirun::forms.sendMessage') }}</button>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}