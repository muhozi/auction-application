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
    return view('home');
})->middleware('guest')->name('home');
	


Auth::routes();
Route::group(['middleware'=>'auth'],function(){
	Route::group(['middleware'=>'regular','namespace'=>'PublicControllers'],function(){
		Route::get('/sell','SellingController@index')->name('sell');
		Route::post('/sell','SellingController@saveAuctionProduct');
		Route::get('/soldproducts', 'SellingController@sold')->name('sold');
		Route::get('/soldproducts/{id}', 'SellingController@soldProductDetails')->name('soldDetails');
		Route::post('/soldproducts/{id}/close', 'SellingController@soldProductClose')->name('soldClose');
		Route::post('/soldproducts/{id}/delete', 'SellingController@soldProductDelete')->name('soldDelete');
		Route::get('/buy','BuyingController@buy')->name('buy');
		Route::get('/buy/{id}','BuyingController@buyProduct')->name('buyProduct');
		Route::post('/buy/{id}','BuyingController@bidProduct')->name('bidProduct');
		
	});
	Route::group(['middleware'=>'admin','prefix'=>'admin','namespace'=>'AdminControllers'],function(){
		Route::get('/','AdminController@index')->name('adminHome');
		Route::get('/auctions','AdminController@allAuctions')->name('allAuctions');
		Route::post('/auctions/{id}/approve','AdminController@approve')->name('approve');
		Route::post('/auctions/approve/all','AdminController@approveall')->name('approveall');
	});

});
Route::get('/test',function(){
		print_r(session());
	});