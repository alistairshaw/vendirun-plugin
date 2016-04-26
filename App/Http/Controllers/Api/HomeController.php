<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Lib\LocaleHelper;

class HomeController extends ApiBaseController {

    /**
     * Returns full list of available actions with the relevant URI listed
     */
    public function index()
    {
        return $this->respond(true, [
            'shipping' => [
                'calculate' => [
                    'endpoint' => route(LocaleHelper::localePrefix() . 'vendirun.api.shippingCalculate'),
                    'requiredParameters' => [
                        'shippingCountryId' => 'int'
                    ],
                    'optionalParameters' => [
                        'shippingType' => 'string'
                    ]
                ]
            ],
            'product' => [
                'variations' => [
                    'endpoint' => route(LocaleHelper::localePrefix() . 'vendirun.api.getVariations', ['productVariationId' => '*productId*']),
                    'requiredParameters' => [],
                    'optionalParameters' => []
                ]
            ]
        ]);
    }

}