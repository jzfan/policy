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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// for test only
Route::put('users', function () {
	auth()->user()->increment('tickets_qty', request('tickets_qty'));
	return 'give 10 tickets';
})->middleware('auth:api');

Route::get('expects', 'SettingController@expects');
Route::get('policies/next', 'PolicyController@next')->middleware('auth:api');
Route::apiResource('policies', 'PolicyController')->middleware('auth:api');
Route::post('policies/{policy}/active', 'PolicyController@active')->middleware('auth:api');
// Route::apiResource('users', 'UserController');
// Route::post('register', 'Auth\ApiAuthController@register');
Route::post('tickets', 'TicketController@prepay')->middleware('auth:api');
// Route::get('lotteries', 'LotteryController@index');
Route::get('lotteries/count', 'LotteryController@count');

Route::get('/oauth/url', 'WxOauthController@url');
Route::get('/oauth/user', 'WxOauthController@user');