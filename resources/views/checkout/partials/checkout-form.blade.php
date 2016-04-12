<form method="post">
    <div class="step-header">
        <span>1</span>
        <div class="title">{{ trans('vendirun::checkout.step1') }}</div>
        <div class="description">{{ trans('vendirun::checkout.step1Description') }}</div>
    </div>
    <div class="step">
        @include('vendirun::product.partials.cart.steps.details')
    </div>
    @if ($stripe)
        <div class="step-header">
            <span>2</span>
            <div class="title">{{ trans('vendirun::checkout.step2') }}</div>
            <div class="description">{{ trans('vendirun::checkout.step2Description') }}</div>
        </div>
        <div class="step">
            @include('vendirun::product.partials.cart.steps.payment-options')
        </div>
    @endif
    <div class="step-header">
        <span>{{ $stripe ? '3' : '2' }}</span>
        <div class="title">{{ trans('vendirun::checkout.step3') }}</div>
        <div class="description">{{ trans('vendirun::checkout.step3Description') }}</div>
    </div>
    <div class="step">
        @include('vendirun::product.partials.cart.steps.order-review')
        <button type="submit" class="btn btn-primary btn-lg pull-right">Buy Now</button>
    </div>
</form>