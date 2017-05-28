<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Auctionproducts;

class AdminController extends Controller
{
    public function index(){
    	$products = \App\Auctionproducts::where('approved',0)->get();
		return view('admin/unprovedAuctions')->with('products',$products);
    }
    public function allAuctions(){
    	$products = \App\Auctionproducts::orderBy('created_at','desc')->get();
		return view('admin/allAuctions')->with('products',$products);
    }
    public function approve($id){
			$auction = Auctionproducts::find($id);
			$auction->approved = 1;
			$auction->save();
			return response()->json(['message'=>'The auction have been successfully saved']);
	}
	public function approveall(){
			$auction = Auctionproducts::where('approved', 0)->update(['approved' => 1]);
			return response()->json(['message'=>'All auctions have been successfully saved']);
	}
}
