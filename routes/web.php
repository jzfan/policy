<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::any('/wechat', 'WechatController@serve');

// Route::group(['middleware' => ['fake_wx_user']], function () { 
	Route::group(['middleware' => ['web', 'wechat.oauth']], function () { 
		Route::get('/oauth', 'WxOauthController@index');
	});
// });
Route::any('/wxpay/notify', 'OrderController@wxNotify');
