<?php

Route::group(['middleware' => ['auth'], 'prefix' => 'user'], function() {
    Route::get('/dashboard', 'Admin\DashboardController@userDashboardView')->name('userDashboardView');

});