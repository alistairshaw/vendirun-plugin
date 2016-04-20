<?php

Route::group(['middleware' => ['web']], function ()
{

    foreach (array_merge([''], LocaleHelper::validLocales()) as $locale)
    {
        Route::group(['middleware' => ['localization'], 'prefix' => $locale, 'namespace' => 'AlistairShaw\Vendirun\App\Http\Controllers'], function () use ($locale)
        {
            $localePrefix = $locale ? $locale . '.' : '';

            Route::group(['prefix' => 'property'], function () use ($localePrefix)
            {
                Route::any('/', ['as' => $localePrefix . 'vendirun.propertySearch', 'uses' => 'Property\PropertyController@index']);
                Route::get('view/{id}/{propertyName?}', ['as' => $localePrefix . 'vendirun.propertyView', 'uses' => 'Property\PropertyController@propertyView']);
                Route::get('search', ['as' => $localePrefix . 'vendirun.propertyRecommend', 'uses' => 'Cms\PageController@temp']);
                Route::get('clear-search', ['as' => $localePrefix . 'vendirun.propertyClearSearch', 'uses' => 'Property\PropertyController@clearSearch']);

                Route::get('search', ['as' => $localePrefix . 'vendirun.searchProperties', 'uses' => 'Property\PropertyController@search']);
                Route::get('category/{categoryName?}', ['as' => $localePrefix . 'vendirun.category', 'uses' => 'Property\CategoryController@index']);
                Route::get('location/{locationName?}', ['as' => $localePrefix . 'vendirun.location', 'uses' => 'Property\LocationController@index']);
                Route::get('property/recommend/{propertyId}', ['as' => $localePrefix . 'vendirun.propertyRecommend', 'uses' => 'Property\PropertyController@recommend']);

                // require user to be logged in
                Route::get('add-to-favourite/{id}', ['as' => $localePrefix . 'vendirun.propertyAddToFav', 'uses' => 'Property\PropertyAuthController@addToFavourite']);
                Route::get('remove-favourite/{id}', ['as' => $localePrefix . 'vendirun.propertyRemoveFav', 'uses' => 'Property\PropertyAuthController@RemoveFavourite']);
                Route::get('view-favourite-properties', ['as' => $localePrefix . 'vendirun.viewFavouriteProperties', 'uses' => 'Property\PropertyAuthController@viewFavouriteProperties']);
            });

            Route::group(['prefix' => 'shop'], function () use ($localePrefix)
            {
                Route::group(['prefix' => 'cart'], function () use ($localePrefix)
                {
                    Route::get('/', ['as' => $localePrefix . 'vendirun.productCart', 'uses' => 'Product\CartController@index']);
                    Route::get('clear', ['as' => $localePrefix . 'vendirun.productCartClear', 'uses' => 'Product\CartController@clear']);
                    Route::get('add/{productVariationId}', ['as' => $localePrefix . 'vendirun.productAddToCart', 'uses' => 'Product\CartController@add']);
                    Route::get('remove/{productVariationId}', ['as' => $localePrefix . 'vendirun.productRemoveFromCart', 'uses' => 'Product\CartController@remove']);
                    Route::post('add', ['as' => $localePrefix . 'vendirun.productAddToCartPost', 'uses' => 'Product\CartController@add']);
                });

                Route::group(['prefix' => 'checkout'], function () use ($localePrefix)
                {
                    Route::get('/', ['as' => $localePrefix . 'vendirun.checkout', 'uses' => 'Checkout\CheckoutController@index']);
                    Route::post('/', ['as' => $localePrefix . 'vendirun.checkoutProcess', 'uses' => 'Checkout\CheckoutController@process']);
                    Route::get('paypal/{orderId}', ['as' => $localePrefix . 'vendirun.checkoutPaypalSuccess', 'uses' => 'Checkout\CheckoutController@paypalSuccess']);
                    Route::get('thanks/{orderId}', ['as' => $localePrefix . 'vendirun.checkoutSuccess', 'uses' => 'Checkout\CheckoutController@success']);
                    Route::get('sorry/{orderId}', ['as' => $localePrefix . 'vendirun.checkoutFailure', 'uses' => 'Checkout\CheckoutController@failure']);
                });

                Route::any('view/{id}/{productName}/{productVariationId?}', ['as' => $localePrefix . 'vendirun.productView', 'uses' => 'Product\ProductController@view']);

                // require user to be logged in
                Route::get('add-to-favourite/{id}', ['as' => $localePrefix . 'vendirun.productAddFavourite', 'uses' => 'Product\FavouriteController@addFavourite']);
                Route::get('remove-favourite/{id}', ['as' => $localePrefix . 'vendirun.productRemoveFavourite', 'uses' => 'Product\FavouriteController@removeFavourite']);
                Route::get('wishlist', ['as' => $localePrefix . 'vendirun.productFavourites', 'uses' => 'Product\FavouriteController@index']);
                Route::get('recommend/{productId}', ['as' => $localePrefix . 'vendirun.productRecommend', 'uses' => 'Product\RecommendController@index']);

                // this one must be last to catch any undefined routes
                Route::any('/{category?}', ['as' => $localePrefix . 'vendirun.productSearch', 'uses' => 'Product\ProductController@index'])->where('category', '(.*)');
            });

            Route::group(['prefix' => 'customer'], function () use ($localePrefix)
            {
                Route::post('contact-form-submit', ['as' => $localePrefix . 'vendirun.contactFormSubmit', 'uses' => 'Customer\CustomerController@processContactForm']);
                Route::post('recommend-a-friend', ['as' => $localePrefix . 'vendirun.recommendAFriend', 'uses' => 'Customer\CustomerController@recommendAFriend']);
                Route::get('logout', ['as' => $localePrefix . 'vendirun.logout', 'uses' => 'Customer\CustomerController@logout']);
                Route::any('register', ['as' => $localePrefix . 'vendirun.register', 'uses' => 'Customer\CustomerController@register']);
                Route::get('email-confirm', ['as' => $localePrefix . 'vendirun.emailConfirm', 'uses' => 'Customer\CustomerController@emailConfirm']);
                Route::get('email-confirm/action', ['as' => $localePrefix . 'vendirun.emailConfirmAction', 'uses' => 'Customer\CustomerController@emailConfirmAction']);
                Route::get('no-permissions', ['as' => $localePrefix . 'vendirun.noPermissions', 'uses' => 'Customer\CustomerController@noPermissions']);

                Route::group(['prefix' => 'password'], function () use ($localePrefix)
                {
                    Route::get('recovery', ['as' => $localePrefix . 'vendirun.passwordRecovery', 'uses' => 'Customer\PasswordController@recovery']);
                    Route::post('recovery', ['as' => $localePrefix . 'vendirun.doPasswordRecovery', 'uses' => 'Customer\PasswordController@processRecovery']);
                    Route::get('recovery/success', ['as' => $localePrefix . 'vendirun.passwordRecoveryOk', 'uses' => 'Customer\PasswordController@completeRecovery']);
                    Route::get('reset/{token}', ['as' => $localePrefix . 'vendirun.passwordReset', 'uses' => 'Customer\PasswordController@resetForm']);
                    Route::post('reset', ['as' => $localePrefix . 'vendirun.doPasswordReset', 'uses' => 'Customer\PasswordController@processReset']);
                    Route::get('reset-ok', ['as' => $localePrefix . 'vendirun.passwordResetOk', 'uses' => 'Customer\PasswordController@completeReset']);
                });

                Route::post('do-register', ['as' => $localePrefix . 'vendirun.doRegister', 'uses' => 'Customer\CustomerController@doRegister']);
                Route::post('do-login', ['as' => $localePrefix . 'vendirun.doLogin', 'uses' => 'Customer\CustomerController@doLogin']);
            });

            // blog
            Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function () use ($localePrefix)
            {
                Route::get('/', ['as' => $localePrefix . 'vendirun.blog', 'uses' => 'PostController@index']);
                Route::get('search', ['as' => $localePrefix . 'vendirun.search', 'uses' => 'PostController@search']);
                Route::any('{catchall}', ['uses' => 'PostController@post'])->where('catchall', '(.*)');
            });

            // staff
            Route::get('/staff/{staffId}/{staffName}', ['as' => $localePrefix . 'vendirun.staff', 'uses' => 'Cms\PageController@staff']);

            // google map cache
            Route::post('vendirun/google-map-cache-get', ['as' => $localePrefix . 'vendirun.mapCache', 'uses' => 'Cms\PageController@mapCacheRetrieve']);
            Route::post('vendirun/google-map-cache-set', ['as' => $localePrefix . 'vendirun.mapCache', 'uses' => 'Cms\PageController@mapCacheSet']);

            // menu example
            Route::any('menu-example', ['as' => $localePrefix . 'vendirun.menu', 'uses' => 'Cms\PageController@menu']);

            // home page
            Route::any('/', ['as' => $localePrefix . 'vendirun.home', 'uses' => 'Cms\PageController@index']);
        });
    }

    // capture any undefined routes and pass to the CMS controller
    Route::any('{catchall}', ['middleware' => ['localization'], 'as' => 'vendirun.cmsPage', 'uses' => 'AlistairShaw\Vendirun\App\Http\Controllers\Cms\PageController@page'])->where('catchall', '(.*)');

});
