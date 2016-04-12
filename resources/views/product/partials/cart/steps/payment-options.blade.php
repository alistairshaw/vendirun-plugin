<div class="payment clearfix">
    @if ($stripe && $paypal)
        <div class="options form-group form-inline">
            <label>
                <input type="radio" name="paymentOption" value="stripe" checked>
                {{ trans('vendirun::forms.creditCard') }}
            </label>
            <label>
                <input type="radio" name="paymentOption" value="paypal">
                {{ trans('vendirun::forms.payPal') }}
            </label>
        </div>
    @endif
    @if ($stripe)
        <div class="stripe-form">
            <div class="form-group">
                <label for="textinput">{{ trans('vendirun::forms.cardHolderName') }}</label>
                <input type="text" name="cardholdername" maxlength="70" placeholder="{{ trans('vendirun::forms.cardHolderName') }}" class="card-holder-name form-control">
            </div>

            <div class="form-group">
                <label for="textinput">{{ trans('vendirun::forms.cardNumber') }}</label>
                <input type="text" id="cardnumber" maxlength="19" placeholder="{{ trans('vendirun::forms.cardNumber') }}" class="card-number form-control">
            </div>

            <div class="expiry-cvv">
                <div class="expiry">
                    <div class="form-group">
                        <label for="textinput">{{ trans('vendirun::forms.cardExpiry') }}</label>
                        <div class="form-inline">
                            <select name="select2" data-stripe="exp-month" class="card-expiry-month stripe-sensitive required form-control">
                                <option value="01" selected="selected">01</option>
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
                                <option value="12">12</option>
                            </select>
                            <span> / </span>
                            <select name="select2" data-stripe="exp-year" class="card-expiry-year stripe-sensitive required form-control">
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
                        <input type="text" id="cvv" placeholder="{{ trans('vendirun::forms.cvv') }}" maxlength="4" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>