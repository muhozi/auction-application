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
}
