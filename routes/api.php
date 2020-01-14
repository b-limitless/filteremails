<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(array('prefix' => 'v1'), function () {
	Route::get('/emailaddress', 'EmailaddressController@index');
	Route::get('/emailaddress/addfield', 'EmailaddressController@addfield');

	Route::post('/users/login', 'UserController@login');
	Route::post('/users/register', 'UserController@store');

	Route::post('/wrongphrases/create', 'WrongphraseController@store');
	Route::get('/wrongphrases/view', 'WrongphraseController@view');
});
