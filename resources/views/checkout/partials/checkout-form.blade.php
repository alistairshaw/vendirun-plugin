<form method="post" id="{{ $paymentGateways->stripe ? 'stripePaymentForm' : 'paymentForm' }}" class="js-checkout-payment-form">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="step-header">
        <span>1</span>
        <div class="title">{{ trans('vendirun::checkout.deliveryDetails') }}</div>
        <div class="description">{{ trans('vendirun::checkout.deliveryDetailsDescription') }}</div>
    </div>
    <div class="step">
        @include('vendirun::checkout.steps.details')
    </div>

    <div class="step-header">
        <span>2</span>
        <div class="title">{{ trans('vendirun::checkout.shippingMethod') }}</div>
        <div class="description">{{ trans('vendirun::checkout.shippingMethodDescription') }}</div>
    </div>
    <div class="step">
        @include('vendirun::checkout.steps.shipping-method')
    </div>

    @if ($paymentGateways->paypal && !$paymentGateways->stripe)
        <div class="step-header">
            <span>3</span>
            <div class="title">{{ trans('vendirun::checkout.payWithPaypal') }}</div>
            <div class="description">{{ trans('vendirun::checkout.payWithPaypalDescription') }}</div>
        </div>
        <div class="step">
            @include('vendirun::checkout.partials.paypal-logo')
            <input type="hidden" name="paymentOption" value="paypal">
        </div>
    @else
        <div class="step-header">
            <span>3</span>
            <div class="title">{{ trans('vendirun::checkout.paymentOptions') }}</div>
            <div class="description">{{ trans('vendirun::checkout.paymentOptionsDescription') }}</div>
        </div>
        <div class="step">
            @include('vendirun::checkout.steps.payment-options')
        </div>
    @endif

    <div class="step-header">
        <span>4</span>
        <div class="title">{{ trans('vendirun::checkout.orderConfirm') }}</div>
        <div class="description">{{ trans('vendirun::checkout.orderConfirmDescription') }}</div>
    </div>
    <div class="step">
        @include('vendirun::checkout.steps.order-review')
        <button type="submit" class="btn btn-primary btn-lg pull-right">Buy Now</button>
    </div>
</form>