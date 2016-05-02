<div class="payment-pending-form">
    <div class="wrapper">
        <h3>{{ trans('vendirun::orders.paymentPending') }}</h3>
        <div class="payment-form">
            <form method="post" action="{{ route(LocaleHelper::localePrefix() . 'vendirun.checkoutProcess') }}" id="{{ $paymentGateways->stripe ? 'stripePaymentForm' : 'paymentForm' }}" class="js-checkout-payment-form js-do-not-validate">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="orderId" value="{{ $order->getId() }}">
                @include('vendirun::checkout.steps.payment-options')
                @include('vendirun::checkout.steps.billing-address')
                <button type="submit" class="btn btn-primary btn-lg pull-right">Pay Now</button>
            </form>
        </div>
    </div>
</div>