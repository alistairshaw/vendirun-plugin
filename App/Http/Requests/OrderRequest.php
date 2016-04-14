<?php namespace AlistairShaw\Vendirun\App\Http\Requests;

use App\Http\Requests\Request;

class OrderRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (Request::has('recalculateShipping')) return [];

        $validation = [
            'emailAddress' => 'required|email',
            'fullName' => 'required',
            'cardHolderName' => 'required',
            'shippingAddressId' => 'required_without_all:shippingaddress1,shippingcity,shippingcountry',
            'shippingaddress1' => 'required_without:shippingAddressId',
            'shippingcity' => 'required_without:shippingAddressId',
            'shippingcountryId' => 'required_without:shippingAddressId'
        ];

        if (!Request::has('billingAddressSameAsShipping'))
        {
            $validation['billingAddressId'] = 'required_without_all:billingaddress1,billingcity,billingcountry';
            $validation['billingaddress1'] = 'required_without:billingAddressId';
            $validation['billingcity'] = 'required_without:billingAddressId';
            $validation['billingcountryId'] = 'required_without:billingAddressId';
        }

        return $validation;
    }

}