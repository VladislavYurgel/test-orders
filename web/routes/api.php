<?php

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('auth/login', 'LoginController@login')->name('auth.login');
    });

    Route::group(['middleware' => 'api.jwt.auth'], function () {
        Route::post('order/goods/add', 'UserOrderController@addGoodsToTheOrder');
        Route::post('order/status/change', 'UserOrderController@changeOrderStatus');
    });
});
