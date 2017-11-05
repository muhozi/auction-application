<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class HomeController extends Controller
{
    public function getApp(){
        return response()->download(public_path('applications/android/Auction.apk'));
    }
    public function home(){
    	return view('home');
    }
    public function register(Request $request) {
	    $user = new \App\User();
	    $user->name = $request->input('firstname') ." " . $request->input('lastname');
	    $user->email = $request->input('email');
	    $user->password = bcrypt('secret');
	    $user->remember_token = bcrypt('secret');
	    $user->save();
	    return Response()->json(['status'=>"Ok"]);
	}
	public function registerB(Request $request){
	    User::create([
	            'firstname' => $request->input('firstname'),
	            'lastname' => $request->input('lastname'),
	            'email' => $request->input('email'),
	            'phone' => $request->input('phone'),
	            'password' => bcrypt($request->input('password')),
	        ]);
	    return Response()->json(['message'=>'You have been successfully registered']);
	}
}
