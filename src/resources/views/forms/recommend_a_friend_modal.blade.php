<input type="hidden" id="modal_error" value="{{ Session::has('showModal') ? 1 : 0 }}">

<!-- Modal -->
<div class="modal fade" id="recommendAFriend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Send To A Friend</h4>
            </div>
            {!! Form::open(array('route' => 'vendirun.recommendAFriend', 'autocomplete' => 'off')) !!}
                <div class="modal-body">
                    <h4>Your Details</h4>
                    <div class="form-group {{ $errors->has('fullName') ? 'has-error' : '' }}">

                        {!! Form::text('fullName', Input::old('fullName'), array('placeholder'=>'Full Name', 'class'=>'form-control')) !!}
                        {!! Form::hidden('property', Input::old('property'), array('id'=>'propertyName')) !!}
                        {!! Form::hidden('propertyId', Input::old('propertyId'), array('id'=>'propertyId')) !!}
                        {!! Form::hidden('formId','Contact form from view property page') !!}
                        @if ($errors->has('fullName')) <p class="help-block">{{ $errors->first('fullName') }}</p> @endif
                    </div>
                    <div class="form-group  {{ $errors->has('emailAddress') ? 'has-error' : '' }}" >
                        {!! Form::label('emailAddress', 'Email Address') !!}
                        {!! Form::text('emailAddress', Input::old('emailAddress'), array('placeholder'=>'Email Address', 'class'=>'form-control')) !!}
                        @if ($errors->has('emailAddress')) <p class="help-block">{{ $errors->first('emailAddress') }}</p> @endif
                    </div>
                    <div class="form-group {{ $errors->has('telephone') ? 'has-error' : '' }}">
                        {!! Form::label('telephone', 'Telephone') !!}
                        {!! Form::text('telephone', Input::old('telephone'), array('placeholder'=>'Telephone', 'class'=>'form-control')) !!}
                        @if ($errors->has('telephone')) <p class="help-block">{{ $errors->first('telephone') }}</p> @endif
                    </div>

                        <h4>Your Friend Details</h4>
                    <div class="form-group {{ $errors->has('fullNameFriend') ? 'has-error' : '' }}" >
                        {!! Form::label('fullName', 'Full Name') !!}
                        {!! Form::text('fullNameFriend', Input::old('fullNameFriend'), array('placeholder'=>'Full Name', 'class'=>'form-control')) !!}
                        @if ($errors->has('fullNameFriend')) <p class="help-block">{{ $errors->first('fullNameFriend') }}</p> @endif
                    </div>
                    <div class="form-group {{ $errors->has('emailAddressFriend') ? 'has-error' : '' }}">
                        {!! Form::label('emailAddress', 'Email Address') !!}
                        {!! Form::text('emailAddressFriend', Input::old('emailAddressFriend'), array('placeholder'=>'Email Address', 'class'=>'form-control')) !!}
                        @if ($errors->has('emailAddressFriend')) <p class="help-block">{{ $errors->first('emailAddressFriend') }}</p> @endif
                    </div>
                    <div class="form-group {{ $errors->has('telephoneFriend') ? 'has-error' : '' }}">
                        {!! Form::label('telephone', 'Telephone') !!}
                        {!! Form::text('telephoneFriend', Input::old('telephoneFriend'), array('placeholder'=>'Telephone', 'class'=>'form-control')) !!}
                        @if ($errors->has('telephoneFriend')) <p class="help-block">{{ $errors->first('telephoneFriend') }}</p> @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
