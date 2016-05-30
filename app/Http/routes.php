<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('/data', 'IndexController@receiveData');

Route::group(['middleware' => 'auth'], function() {
	Route::get('/register', 'RegisterController@index');
	Route::post('/regis', 'RegisterController@store');
	Route::post('/device/edit', 'RegisterController@edit');
	Route::post('/device/delete', 'RegisterController@delete');

	Route::get('/device/list/data', 'DeviceController@index');
	Route::get('/device/{device_id}/data', 'DeviceController@device');

	Route::get('{any}', 'IndexController@index')->where('any', '.*');
});