<?php namespace AlistairShaw\Vendirun\App\Lib\Cart;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;

class Order {

    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function createOrder($params)
    {
        $products = $this->cart->getProducts();

        dd($products);

        $data = [
            'full_name' => $params['fullName'],
            'billing_address_same_as_shipping' => false,
            'shipping_type' => $products->shippingType,
            'shipping_amount' => $products->shipping,
            'shipping_tax_rate' => $products->shippingTaxRate,
            'shipping_country_id' => $products->countryId,
            'products' => $this->cart->basicList()
        ];

        if (isset($params['shippingAddressId']))
        {
            $data['shipping_address_id'] = $params['shippingAddressId'];
        }
        else
        {
            $data['shipping_address1'] = $params['shippingaddress1'];
            $data['shipping_address2'] = $params['shippingaddress2'];
            $data['shipping_address3'] = $params['shippingaddress3'];
            $data['shipping_city'] = $params['shippingcity'];
            $data['shipping_state'] = $params['shippingstate'];
            $data['shipping_postcode'] = $params['shippingpostcode'];
            $data['shipping_country_id'] = $params['shippingcountryId'];
        }

        if (isset($params['billingAddressId']) && !isset($params['billingAddressSameAsShipping']))
        {
            $data['billing_address_id'] = $params['billingAddressId'];
        }
        else
        {
            $data['billing_address1'] = $params['billingaddress1'];
            $data['billing_address2'] = $params['billingaddress2'];
            $data['billing_address3'] = $params['billingaddress3'];
            $data['billing_city'] = $params['billingcity'];
            $data['billing_state'] = $params['billingstate'];
            $data['billing_postcode'] = $params['billingpostcode'];
            $data['billing_country_id'] = $params['billingcountryId'];
        }

        if (isset($params['billingAddressSameAsShipping'])) $data['billing_address_same_as_shipping'] = true;

        dd('Data for API', $data);

        VendirunApi::makeRequest('order/create', $params);
    }

}