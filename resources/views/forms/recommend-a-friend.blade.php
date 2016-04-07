<div class="recommend-a-friend js-recommend-a-friend-form{{ (isset($hideRacForm) && $hideRacForm) ? ' hide' : '' }}">
    {!! Form::open(['route' => 'vendirun.recommendAFriend', 'autocomplete' => 'off', 'class' => 'js-validate-form']) !!}
    {!! Form::token() !!}
    {!! Form::hidden('property', (isset($property) ? $property->title : Input::old('property')), ['id'=>'propertyName']) !!}
    {!! Form::hidden('propertyId', (isset($property) ? $property->id : Input::old('propertyId')), ['id'=>'propertyId']) !!}
    {!! Form::hidden('formId', 'Recommend a Friend') !!}
    <h2>{{ trans('vendirun::forms.sendToFriend') }}</h2>
    <p>{{ trans('vendirun::forms.sendToFriendNote') }}</p>
    <p><em>{{ trans('vendirun::forms.privacyAssurance') }}</em></p>

    <div class="row">
        <div class="col-sm-6">
            <h3>{{ trans('vendirun::forms.yourDetails') }}</h3>

            <div class="form-group {{ $errors->has('fullName') ? 'has-error' : '' }}">
                {!! Form::label('fullName', trans('vendirun::forms.fullName')) !!}
                {!! Form::text('fullName', Input::old('fullName'), ['placeholder'=>trans('vendirun::forms.fullName'), 'class'=>'form-control', 'required'=>'required']) !!}
                @if ($errors->has('fullName'))
                    <p class="help-block">{{ $errors->first('fullName') }}</p>
                @endif
            </div>
            <div class="form-group  {{ $errors->has('emailAddress') ? 'has-error' : '' }}">
                {!! Form::label('emailAddress', trans('vendirun::forms.email')) !!}
                {!! Form::email('emailAddress', Input::old('emailAddress'), ['placeholder'=>trans('vendirun::forms.email'), 'class'=>'form-control', 'required'=>'required']) !!}
                @if ($errors->has('emailAddress'))
                    <p class="help-block">{{ $errors->first('emailAddress') }}</p>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <h3>{{ trans('vendirun::forms.friendDetails') }}</h3>

            <div class="form-group {{ $errors->has('fullNameFriend') ? 'has-error' : '' }}">
                {!! Form::label('fullName', trans('vendirun::forms.fullName')) !!}
                {!! Form::text('fullNameFriend', Input::old('fullNameFriend'), ['placeholder'=>trans('vendirun::forms.fullName'), 'class'=>'form-control', 'required'=>'required']) !!}
                @if ($errors->has('fullNameFriend'))
                    <p class="help-block">{{ $errors->first('fullNameFriend') }}</p>
                @endif
            </div>
            <div class="form-group {{ $errors->has('emailAddressFriend') ? 'has-error' : '' }}">
                {!! Form::label('emailAddress', trans('vendirun::forms.email')) !!}
                {!! Form::email('emailAddressFriend', Input::old('emailAddressFriend'), ['placeholder'=>trans('vendirun::forms.email'), 'class'=>'form-control', 'required'=>'required']) !!}
                @if ($errors->has('emailAddressFriend'))
                    <p class="help-block">{{ $errors->first('emailAddressFriend') }}</p>
                @endif
            </div>
        </div>
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> {{ trans('vendirun::forms.send') }}</button>
            <a href="{{ URL::previous() }}" class="btn btn-default js-send-to-friend-close"><i class="fa fa-remove"></i> {{ trans('vendirun::forms.cancel') }}</a>
        </div>
    </div>
    {!! Form::close() !!}
</div>
