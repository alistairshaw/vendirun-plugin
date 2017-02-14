<?php namespace AlistairShaw\Vendirun\App\Http\Requests;

use App\Http\Requests\Request;

class OrderRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (Request::has('recalculateShipping') || Request::has('orderId')) return [];

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

    public function messages()
    {
        return [
            'billingaddressId.required_without_all' => trans('vendirun::checkout.billingAddressMissing'),
            'billingaddress1.required_without' => trans('vendirun::checkout.billingAddressLineOneMissing'),
            'billingcity.required_without' => trans('vendirun::checkout.billingAddressCityMissing'),
            'billingcountryId.required_without' => trans('vendirun::checkout.billingAddressCountryMissing'),
            'shippingaddressId.required_without_all' => trans('vendirun::checkout.shippingAddressMissing'),
            'shippingaddress1.required_without' => trans('vendirun::checkout.shippingAddressLineOneMissing'),
            'shippingcity.required_without' => trans('vendirun::checkout.shippingAddressCityMissing'),
            'shippingcountryId.required_without' => trans('vendirun::checkout.shippingAddressCountryMissing')
        ];
    }

}