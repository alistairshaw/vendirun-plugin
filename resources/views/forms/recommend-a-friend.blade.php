<div class="recommend-a-friend js-recommend-a-friend-form hide">
    {!! Form::open(['route' => 'vendirun.recommendAFriend', 'autocomplete' => 'off', 'class' => 'js-validate-form']) !!}
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
    {!! Form::hidden('property', Input::old('property'), array('id'=>'propertyName')) !!}
    {!! Form::hidden('propertyId', Input::old('propertyId'), array('id'=>'propertyId')) !!}
    {!! Form::hidden('formId','Recommend a Friend') !!}
    <div class="row">
        <div class="col-sm-12">
            <h2>Send to a Friend</h2>
            <p>Fill in some basic information below, and we will send your friend an email with a link! Easy as that!</p>
            <p><em>Don't worry, we won't ever share this info with anyone without asking you first.</em></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <h3>Your Details</h3>
            <div class="form-group {{ $errors->has('fullName') ? 'has-error' : '' }}">
                {!! Form::label('fullName', 'Your Name') !!}
                {!! Form::text('fullName', Input::old('fullName'), array('placeholder'=>'Full Name', 'class'=>'form-control', 'required'=>'required')) !!}
                @if ($errors->has('fullName')) <p class="help-block">{{ $errors->first('fullName') }}</p> @endif
            </div>
            <div class="form-group  {{ $errors->has('emailAddress') ? 'has-error' : '' }}">
                {!! Form::label('emailAddress', 'Email Address') !!}
                {!! Form::email('emailAddress', Input::old('emailAddress'), array('placeholder'=>'Email Address', 'class'=>'form-control', 'required'=>'required')) !!}
                @if ($errors->has('emailAddress')) <p class="help-block">{{ $errors->first('emailAddress') }}</p> @endif
            </div>
        </div>
        <div class="col-sm-6">
            <h3>Your Friend's Details</h3>
            <div class="form-group {{ $errors->has('fullNameFriend') ? 'has-error' : '' }}">
                {!! Form::label('fullName', 'Their Name') !!}
                {!! Form::text('fullNameFriend', Input::old('fullNameFriend'), array('placeholder'=>'Full Name', 'class'=>'form-control', 'required'=>'required')) !!}
                @if ($errors->has('fullNameFriend')) <p class="help-block">{{ $errors->first('fullNameFriend') }}</p> @endif
            </div>
            <div class="form-group {{ $errors->has('emailAddressFriend') ? 'has-error' : '' }}">
                {!! Form::label('emailAddress', 'Email Address') !!}
                {!! Form::email('emailAddressFriend', Input::old('emailAddressFriend'), array('placeholder'=>'Email Address', 'class'=>'form-control', 'required'=>'required')) !!}
                @if ($errors->has('emailAddressFriend')) <p class="help-block">{{ $errors->first('emailAddressFriend') }}</p> @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Send</button>
            <button type="button" class="btn btn-default js-send-to-friend-close"><i class="fa fa-remove"></i> Cancel</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
