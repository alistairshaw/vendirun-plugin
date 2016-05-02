@foreach ($payments as $payment)
    <?php $payment = $payment->getArray() ?>
    <div class="payment-details">
        <div class="wrapper">
            <div class="payment-made">
                {{ trans('vendirun::product.paymentDate') }}<br>
                <span>{{ date(Config::get('vendirun.dateFormat', 'jS, M Y'), strtotime($payment['paymentDate'])) }}</span>
            </div>
            <div class="total">
                {{ trans('vendirun::product.total') }}<br>
                <span>{{ CurrencyHelper::formatWithCurrency($payment['amount'], false, '') }}</span>
            </div>
            <div class="payment-type">
                {{ trans('vendirun::product.paymentMethod') }}<br>
                <span>{{ $payment['paymentType'] }}</span>
            </div>
        </div>
    </div>
@endforeach