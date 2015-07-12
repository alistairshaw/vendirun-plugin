<?php

Route::group(['namespace' => 'Ambitiousdigital\Vendirun\Controllers', 'prefix' => 'property'], function()
{
	Route::any('/', ['as'=>'vendirun.propertySearch', 'uses' => 'Property\PropertyController@index']);
	Route::get('clear-search', ['as'=>'vendirun.propertyClearSearch', 'uses' => 'Property\PropertyController@clearSearch']);
	Route::get('view/{id}/{propertyName?}', ['as'=>'vendirun.propertyView', 'uses' => 'Property\PropertyController@propertyView']);

	Route::get('add-to-favourite/{id}', ['as'=>'vendirun.propertyAddToFav', 'uses' => 'Property\PropertyController@addToFavourite']);
	Route::get('remove-favourite/{id}', ['as'=>'vendirun.propertyRemoveFav', 'uses' => 'Property\PropertyController@RemoveFavourite']);
	Route::get('view-favourite-properties', ['as'=>'vendirun.viewFavouriteProperties', 'uses' => 'Property\PropertyController@viewFavouriteProperties']);
	Route::get('search', ['as'=>'vendirun.searchProperties', 'uses' => 'Property\PropertyController@search']);

	Route::get('categories', ['as'=>'vendirun.categories', 'uses' => 'Property\CategoryController@index']);
	Route::get('location/{locationName?}/{locationId?}', ['as'=>'vendirun.location', 'uses' => 'Property\LocationController@index']);
});

Route::group(['namespace' => 'Ambitiousdigital\Vendirun\Controllers', 'prefix' => 'customer'], function()
{
	Route::post('contact-form-submit', ['as' => 'vendirun.contactFormSubmit', 'uses' => 'Customer\CustomerController@processContactForm']);
	Route::post('recommend-a-friend', ['as' => 'vendirun.recommendAFriend', 'uses' => 'Customer\CustomerController@recommendAFriend']);
	Route::get('logout', ['as' => 'vendirun.logout', 'uses' => 'Customer\CustomerController@logout']);
	Route::any('register', ['as' => 'vendirun.register', 'uses' => 'Customer\CustomerController@register']);

	Route::any('do-register', ['as' => 'vendirun.doRegister', 'uses' => 'Customer\CustomerController@doRegister']);
	Route::any('do-login', ['as' => 'vendirun.doLogin', 'uses' => 'Customer\CustomerController@doLogin']);
});

// home page
Route::any('/', ['as'=>'vendirun.home', 'uses' => 'Ambitiousdigital\Vendirun\Controllers\Cms\PageController@index']);

// capture any undefined routes and pass to the CMS controller
Route::any( '{catchall}', ['uses' => 'Ambitiousdigital\Vendirun\Controllers\Cms\PageController@page'])->where('catchall', '(.*)');