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

Route::post('login','Api\AuthController@postLogin');
Route::post('registration','Api\AuthController@postRegistration');
Route::post('send-reset-password-code','Api\AuthController@sendToken');
Route::post('reset-password','Api\AuthController@resetPassword');

Route::group(['middleware' =>['auth:api'],'namespace'=>'Api'],function (){

    //Profile
    Route::get('profile', 'ProfileController@profile');
    Route::post('update-profile', 'ProfileController@profileUpdate');

});
