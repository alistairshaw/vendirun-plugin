<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Lib\LocaleHelper;

class HomeController extends ApiBaseController {

    /**
     * Returns full list of available actions with the relevant URI listed
     */
    public function index()
    {
        return $this->respond(true, [
            'cart' => [
                'calculate' => [
                    'method' => 'GET',
                    'endpoint' => route(LocaleHelper::localePrefix() . 'vendirun.api.cart.calculate'),
                    'requiredParameters' => [
                        'shippingCountryId' => 'int'
                    ],
                    'optionalParameters' => [
                        'shippingType' => 'string'
                    ]
                ],
                'add' => [
                    'method' => 'POST',
                    'endpoint' => route(LocaleHelper::localePrefix() . 'vendirun.api.cart.add'),
                    'requiredParameters' => [
                        'productVariationId' => 'int'
                    ],
                    'optionalParameters' => [
                        'quantity' => 'int'
                    ]
                ],
                'remove' => [
                    'method' => 'POST',
                    'endpoint' => route(LocaleHelper::localePrefix() . 'vendirun.api.cart.remove'),
                    'requiredParameters' => [
                        'productVariationId' => 'int'
                    ],
                    'optionalParameters' => [
                        'quantity' => 'int'
                    ]
                ]
            ],
            'product' => [
                'find' => [
                    'method' => 'GET',
                    'endpoint' => route(LocaleHelper::localePrefix() . 'vendirun.api.product.find', ['productId' => '*productId*']),
                    'requiredParameters' => [
                        'productId' => 'int'
                    ],
                    'optionalParameters' => []
                ]
            ]
        ]);
    }

}