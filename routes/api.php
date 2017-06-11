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
Route::post('/', function (Request $request) {
    $cities = ['Kigali'=>['Nyarugenge'=>30,'Gasabo'=>40,'Kicukiro'=>13]];
    //return Response()->json($cities);
    $user = new \App\User();
    $user->name = $request->input('firstname') ." " . $request->input('lastname');
    $user->email = $request->input('email');
    $user->password = bcrypt('secret');
    $user->remember_token = bcrypt('secret');
    $user->save();
    return Response()->json(['status'=>"Ok"]);
});
Route::post('register',function(Request $request){
    App\User::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
        ]);
    return Response()->json(['message'=>'You have been successfully registered']);
});
Route::group(['middleware'=>'auth:api'],function () {
    Route::get('buy','ApiControllers\MainController@bids');
    Route::get('bid/{id}','ApiControllers\MainController@bid');
    Route::get('auctions','ApiControllers\MainController@myauctions');
    Route::get('/user', 'ApiControllers\MainController@user');
    Route::post('/auctions/save', 'ApiControllers\MainController@saveAuction');
    Route::post('/bid/{id}', 'ApiControllers\MainController@bidProduct');
    Route::post('/logout', 'ApiControllers\MainController@logout');

});
