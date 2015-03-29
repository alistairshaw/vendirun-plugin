<?php


Route::group(['namespace' => 'Ambitiousdigital\Vendirun\Controllers', 'prefix' => ''], function()
{
	Route::any('/property', ['as'=>'vendirun.propertySearch', 'uses' => 'Property\PropertyController@index']);
	Route::get('/property-view/{id}/{propertyName}', ['as'=>'vendirun.propertyView', 'uses' => 'PropertyController@propertyView']);
	Route::get('/property/add-to-favourite/{id}', ['as'=>'vendirun.propertyAddToFav', 'uses' => 'PropertyController@addToFavourite']);
	Route::get('/property/remove-favourite/{id}', ['as'=>'vendirun.propertyRemoveFav', 'uses' => 'PropertyController@RemoveFavourite']);
	Route::get('/property/view-favourite-properties/', ['as'=>'vendirun.viewFavouriteProperties', 'uses' => 'PropertyController@viewFavouriteProperties']);

	Route::get('/property/location/', ['as'=>'vendirun.location', 'uses' => 'PropertyController@location']);


	Route::post('/contact-form-submit', ['as'=>'vendirun.contactFormSubmit', 'uses' => 'CustomerController@processContactForm']);
	Route::post('/recommend-a-friend', ['as'=>'vendirun.recommendAFriend', 'uses' => 'CustomerController@recommendAFriend']);
	Route::get('/logout', ['as'=>'vendirun.logout', 'uses' => 'CustomerController@logout']);
	Route::any('register', ['as'=>'vendirun.register', 'uses' => 'CustomerController@register']);

	Route::any('/do-register', ['as'=>'vendirun.doRegister', 'uses' => 'CustomerController@doRegister']);
	Route::any('/do-login', ['as'=>'vendirun.doLogin', 'uses' => 'CustomerController@doLogin']);

});



