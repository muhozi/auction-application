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
Route::post('/','HomeController@register');
Route::post('register','HomeController@register@registerB');
Route::group(['middleware'=>'auth:api'],function () {
    Route::get('buy','ApiControllers\MainController@bids');
    Route::get('bid/{id}','ApiControllers\MainController@bid');
    Route::get('auctions','ApiControllers\MainController@myauctions');
    Route::get('/user', 'ApiControllers\MainController@user');
    Route::post('/auctions/save', 'ApiControllers\MainController@saveAuction');
    Route::post('/bid/{id}', 'ApiControllers\MainController@bidProduct');
    Route::post('/logout', 'ApiControllers\MainController@logout');

});
