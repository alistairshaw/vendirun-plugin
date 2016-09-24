<div class="address-select">
    @if ($customer && $customer->getAddresses())
        @foreach ($customer->getAddresses() as $address)
            <label>
                <ul class="address">
                    <li>{{ $address->getArray()['address1'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['address2'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['address3'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['city'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['state'] }}&nbsp;</li>
                    <li>{{ $address->getArray()['postcode'] }}&nbsp;</li>
                    @if ($showSelector)
                        <li class="selector">
                            <input type="radio" name="{{ $prefix . 'addressId' }}" id="{{ $prefix . 'addressId' }}" value="{{ $address->getId() }}"{{ old($prefix . 'addressId', $defaultAddress->getId()) == $address->getId() ? ' checked' : '' }}>
                        </li>
                    @endif
                    <li class="address-links">
                        <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.address.edit', ['id' => $address->getId()]) }}">Edit</a>
                        <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.customer.address.delete', ['id' => $address->getId()]) }}">Delete</a>
                    </li>
                </ul>
            </label>
        @endforeach
    @endif
</div>