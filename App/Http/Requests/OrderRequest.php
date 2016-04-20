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
            'shippingaddressId' => 'required_without_all:shippingaddress1,shippingcity,shippingcountry',
            'shippingaddress1' => 'required_without:shippingaddressId',
            'shippingcity' => 'required_without:shippingaddressId',
            'shippingcountryId' => 'required_without:shippingaddressId'
        ];

        if (!Request::has('billingAddressSameAsShipping'))
        {
            $validation['billingaddressId'] = 'required_without_all:billingaddress1,billingcity,billingcountry';
            $validation['billingaddress1'] = 'required_without:billingaddressId';
            $validation['billingcity'] = 'required_without:billingaddressId';
            $validation['billingcountryId'] = 'required_without:billingaddressId';
        }

        return $validation;
    }

}