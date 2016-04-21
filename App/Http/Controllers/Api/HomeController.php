<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;

class HomeController extends VendirunBaseController {

    /**
     * Returns full list of available actions with the relevant URI listed
     */
    public function index()
    {
        return [
            'shipping' => [
                'calculate' => [
                    'endpoint' => route('en.vendirun.apiShippingCalculate'),
                    'requiredParameters' => [
                        'shippingCountryId' => 'int'
                    ],
                    'optionalParameters' => [
                        'shippingType' => 'string'
                    ]
                ]
            ]
        ];
    }

}