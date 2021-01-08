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

    });
    Route::get('/order', 'UserOrderController@order');
});

Route::get('coupon', 'CouponController@coupon');
Route::group(['prefix' => 'coupon'], function (){
    Route::get('/add', 'CouponController@add');
    Route::get('/edit', 'CouponController@exit');
    Route::get('/del', 'CouponController@del');
    Route::get('/query', 'CouponController@query');
    Route::get('/receive', 'CouponController@receive');
    Route::get('/use', 'CouponController@useCoupon');
    Route::get('/grant', 'CouponGrantController@grantTest');

});

Route::group(['prefix' => 'user'], function (){
    Route::get('/add', 'UserController@add');
    Route::get('/edit', 'UserController@edit');
    Route::get('/del', 'UserController@del');
    Route::get('/query','UserController@query');

});

Route::group(['prefix' => 'order'], function (){
    Route::get('/add', 'OrderController@add');
    Route::get('/edit', 'OrderController@edit');
    Route::get('/del', 'OrderController@del');
    Route::get('/query', 'OrderController@query');
});

Route::group(['prefix' => 'activity'], function () {
    Route::get('/add', 'ActivityController@add');
    Route::get('/edit', 'ActivityController@edit');
    Route::get('/del', 'ActivityController@del');
    Route::get('/query', 'ActivityController@query');
});
