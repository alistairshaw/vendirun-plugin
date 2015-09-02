<?php

Route::group(['namespace' => 'AlistairShaw\Vendirun\App\Http\Controllers', 'prefix' => 'property'], function()
{
	Route::any('/', ['as'=>'vendirun.propertySearch', 'uses' => 'Property\PropertyController@index']);
	Route::get('clear-search', ['as'=>'vendirun.propertyClearSearch', 'uses' => 'Property\PropertyController@clearSearch']);
	Route::get('view/{id}/{propertyName?}', ['as'=>'vendirun.propertyView', 'uses' => 'Property\PropertyController@propertyView']);
	Route::get('search', ['as'=>'vendirun.searchProperties', 'uses' => 'Property\PropertyController@search']);
	Route::get('category/{categoryName?}', ['as'=>'vendirun.category', 'uses' => 'Property\CategoryController@index']);
	Route::get('location/{locationName?}', ['as'=>'vendirun.location', 'uses' => 'Property\LocationController@index']);
	Route::get('property/recommend/{propertyId}', ['as'=>'vendirun.propertyRecommend', 'uses' => 'Property\PropertyController@recommend']);

    // require user to be logged in
	Route::get('add-to-favourite/{id}', ['as'=>'vendirun.propertyAddToFav', 'uses' => 'Property\PropertyAuthController@addToFavourite']);
	Route::get('remove-favourite/{id}', ['as'=>'vendirun.propertyRemoveFav', 'uses' => 'Property\PropertyAuthController@RemoveFavourite']);
	Route::get('view-favourite-properties', ['as'=>'vendirun.viewFavouriteProperties', 'uses' => 'Property\PropertyAuthController@viewFavouriteProperties']);
});

Route::group(['namespace' => 'AlistairShaw\Vendirun\App\Http\Controllers', 'prefix' => 'customer'], function()
{
	Route::post('contact-form-submit', ['as' => 'vendirun.contactFormSubmit', 'uses' => 'Customer\CustomerController@processContactForm']);
	Route::post('recommend-a-friend', ['as' => 'vendirun.recommendAFriend', 'uses' => 'Customer\CustomerController@recommendAFriend']);
	Route::get('logout', ['as' => 'vendirun.logout', 'uses' => 'Customer\CustomerController@logout']);
	Route::any('register', ['as' => 'vendirun.register', 'uses' => 'Customer\CustomerController@register']);

	Route::group(['prefix' => 'password'], function()
    {
        Route::get('recovery', ['as' => 'vendirun.passwordRecovery', 'uses' => 'Customer\PasswordController@recovery']);
        Route::post('recovery', ['as' => 'vendirun.doPasswordRecovery', 'uses' => 'Customer\PasswordController@processRecovery']);
        Route::get('recovery/success', ['as' => 'vendirun.passwordRecoveryOk', 'uses' => 'Customer\PasswordController@completeRecovery']);
        Route::get('reset/{token}', ['as' => 'vendirun.passwordReset', 'uses' => 'Customer\PasswordController@resetForm']);
        Route::post('reset', ['as' => 'vendirun.doPasswordReset', 'uses' => 'Customer\PasswordController@processReset']);
        Route::get('reset-ok', ['as' => 'vendirun.passwordResetOk', 'uses' => 'Customer\PasswordController@completeReset']);
    });

	Route::post('do-register', ['as' => 'vendirun.doRegister', 'uses' => 'Customer\CustomerController@doRegister']);
	Route::post('do-login', ['as' => 'vendirun.doLogin', 'uses' => 'Customer\CustomerController@doLogin']);
});

// home page
Route::any('/', ['as'=>'vendirun.home', 'uses' => 'AlistairShaw\Vendirun\App\Http\Controllers\Cms\PageController@index']);

// google map cache
Route::post('vendirun/google-map-cache-get', ['as'=>'vendirun.mapCache', 'uses' => 'AlistairShaw\Vendirun\App\Http\Controllers\Cms\PageController@mapCacheRetrieve']);
Route::post('vendirun/google-map-cache-set', ['as'=>'vendirun.mapCache', 'uses' => 'AlistairShaw\Vendirun\App\Http\Controllers\Cms\PageController@mapCacheSet']);

// menu example
Route::any('/menu', ['as'=>'vendirun.menu', 'uses' => 'AlistairShaw\Vendirun\App\Http\Controllers\Cms\PageController@menu']);

// capture any undefined routes and pass to the CMS controller
Route::any( '{catchall}', ['uses' => 'AlistairShaw\Vendirun\App\Http\Controllers\Cms\PageController@page'])->where('catchall', '(.*)');