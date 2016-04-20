<div class="payment clearfix">
    @if ($paymentGateways->stripe && $paymentGateways->paypal)
        <div class="options form-group form-inline">
            <label>
                <input type="radio" name="paymentOption" value="paypal" checked>
                {{ trans('vendirun::forms.payPal') }}
            </label>
            <label>
                <input type="radio" name="paymentOption" value="stripe">
                {{ trans('vendirun::forms.creditCard') }}
            </label>
        </div>
    @endif
    @if ($paymentGateways->stripe)
        <div class="stripe-form hidden">
            <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
            <script type="text/javascript">
                Stripe.setPublishableKey('{{ $paymentGateways->stripeSettings->sandbox_mode ? $paymentGateways->stripeSettings->test_publishable : $paymentGateways->stripeSettings->publishable }}');
            </script>
            <div class="alert alert-danger js-payment-errors hidden"></div>

            <div class="form-group">
                <label for="textinput">{{ trans('vendirun::forms.cardHolderName') }}</label>
                <input type="text" name="cardHolderName" maxlength="70" placeholder="{{ trans('vendirun::forms.cardHolderName') }}" class="form-control" value="{{ old('cardHolderName', '') }}">
            </div>

            <div class="form-group">
                <label for="textinput">{{ trans('vendirun::forms.cardNumber') }}</label>
                <input type="text" maxlength="19" placeholder="{{ trans('vendirun::forms.cardNumber') }}" class="form-control" data-stripe="number" value="">
            </div>

            <div class="expiry-cvv">
                <div class="expiry">
                    <div class="form-group">
                        <label for="textinput">{{ trans('vendirun::forms.cardExpiry') }}</label>
                        <div class="form-inline">
                            <select class="form-control" data-stripe="exp-month">
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12" selected="selected">12</option>
                            </select>
                            <span> / </span>
                            <select class="form-control" data-stripe="exp-year">
                                @for($i = date("Y"); $i < date("Y") + 20; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="cvv">
                    <div class="form-group">
                        <label for="textinput">{{ trans('vendirun::forms.cvv') }}</label>
                        <input type="text" id="cvv" placeholder="{{ trans('vendirun::forms.cvv') }}" maxlength="4" class="form-control" data-stripe="cvc" value="">
                    </div>
                </div>
            </div>
        </div>
    @endif
    <h2>Billing Address</h2>
    <div class="form-group">
        <label class="checkbox">
            <input type="checkbox" value="1" name="billingAddressSameAsShipping" id="billingAddressSameAsShipping" checked>
            {{ trans('vendirun::checkout.billingAddressSameAsShipping') }}
        </label>
    </div>
    @if ($customer)
        @include('vendirun::customer.partials.address-select', ['selected' => $defaultAddress, 'prefix' => 'billing'])
    @else
        @include('vendirun::customer.partials.address-form', ['prefix' => 'billing'])
    @endif
</div>