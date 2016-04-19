<h3>{{ trans('vendirun::customer.selectAddress') }}</h3>
<div class="address-select">
    @if ($customer)
        @foreach ($customer->getAddresses() as $address)
            <label>
                <ul class="address">
                    <li>{{ $address->getArray()['address1'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['address2'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['address3'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['city'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['state'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['postcode'] }}&nbsp;</li>
                    <li class="selector">
                        <input type="radio" name="{{ $prefix . 'addressId' }}" id="{{ $prefix . 'addressId' }}" value="{{ $address->getId() }}"{{ old($prefix . 'addressId', $defaultAddress->getId()) == $address->getId() ? ' checked' : '' }}>
                    </li>
                </ul>
            </label>
        @endforeach
    @endif
</div>