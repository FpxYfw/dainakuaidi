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


Route::get('/test', 'TestController@test');

Route::group(['prefix' => 'admin'],function (){
    Route::get('/login', 'LoginController@login');
    // 地址
    Route::group(['prefix' => 'address'], function () {
        Route::get('/add', 'UserAddressController@add');
        Route::get('/exit', 'UserAddressController@exit');
        Route::get('/del', 'UserAddressController@del');

        // 还原   （还未实现）
        Route::get('/recovery', 'UserAddressController@recovery');
    });
    Route::get('/order', 'UserOrderController@order');
    // 订单
    Route::group(['prefix' => 'order'], function (){
//        Route::get();
    });
});