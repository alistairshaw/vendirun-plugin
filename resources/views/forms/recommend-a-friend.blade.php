<div class="recommend-a-friend js-recommend-a-friend-form{{ (isset($hideRacForm) && $hideRacForm) ? ' hide' : '' }}">
    <form method="POST" action="{{ route('vendirun.recommendAFriend') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="propertyId" value="{{ (isset($property) ? $property->id : Request::old('propertyId')) }}">
        <input type="hidden" name="property" value="{{ (isset($property) ? $property->title : Request::old('property')) }}">
        <input type="hidden" name="productId" value="{{ (isset($product) ? $product->getId() : Request::old('productId')) }}">
        <input type="hidden" name="product" value="{{ (isset($product) ? $product->getProductName() : Request::old('product')) }}">
        <input type="hidden" name="formId" value="Recommend a Friend">
        <h2>{{ trans('vendirun::forms.sendToFriend') }}</h2>
        <p>{{ trans('vendirun::forms.sendToFriendNote') }}</p>
        <p><em>{{ trans('vendirun::forms.privacyAssurance') }}</em></p>

        <div class="row">
            <div class="col-sm-6">
                <h3>{{ trans('vendirun::forms.yourDetails') }}</h3>

                <div class="form-group">
                    <label for="fullName">{{ trans('vendirun::forms.fullName') }}</label>
                    <input type="text" class="form-control" name="fullName" id="fullName" placeholder="{{ trans('vendirun::forms.fullName') }}" value="{{ isset($customer) ? $customer->fullName() : '' }}" required>
                </div>
                <div class="form-group ">
                    <label for="emailAddress">{{ trans('vendirun::forms.email') }}</label>
                    <input type="email" class="form-control" name="emailAddress" id="emailAddress" placeholder="{{ trans('vendirun::forms.email') }}" required value="{{ isset($customer) ? $customer->getPrimaryEmail() : '' }}">
                </div>
            </div>
            <div class="col-sm-6">
                <h3>{{ trans('vendirun::forms.friendDetails') }}</h3>

                <div class="form-group">
                    <label for="fullName">{{ trans('vendirun::forms.fullName') }}</label>
                    <input type="text" class="form-control" name="fullNameFriend" id="fullNameFriend" value="" placeholder="{{ trans('vendirun::forms.fullName') }}" required>
                </div>
                <div class="form-group">
                    <label for="emailAddress">{{ trans('vendirun::forms.email') }}</label>
                    <input type="email" class="form-control" name="emailAddressFriend" id="emailAddressFriend" value="" placeholder="{{ trans('vendirun::forms.email') }}" required>
                </div>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-envelope"></i> {{ trans('vendirun::forms.send') }}</button>
                <a href="{{ URL::previous() }}" class="btn btn-default js-send-to-friend-close"><i class="fa fa-remove"></i> {{ trans('vendirun::forms.cancel') }}
                </a>
            </div>
        </div>
    </form>
</div>
