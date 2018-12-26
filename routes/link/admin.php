<?php

Route::group(['middleware' => ['auth','admin'], 'prefix' => 'admin'], function() {
    Route::get('/dashboard', 'Admin\DashboardController@adminDashboardView')->name('adminDashboardView');

});