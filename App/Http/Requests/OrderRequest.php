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

        return [
            'title' => 'required',
            'emailAddress' => 'required|email',
            'fullName' => 'required',
            'cardHolderName' => 'required',
            'shippingAddressId' => 'required_without_all:shippingaddress1,shippingcity,shippingcountry',
            'billingAddressId' => 'required_without_all:billingaddress1,billingcity,billingcountry',
            'shippingaddress1' => 'required_without:shippingAddressId',
            'shippingcity' => 'required_without:shippingAddressId',
            'shippingcountryId' => 'required_without:shippingAddressId',
            'billingaddress1' => 'required_without:billingAddressId',
            'billingcity' => 'required_without:billingAddressId',
            'billingcountryId' => 'required_without:billingAddressId',
        ];
    }

}