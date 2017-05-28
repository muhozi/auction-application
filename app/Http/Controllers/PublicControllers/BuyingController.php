<?php

namespace App\Http\Controllers\PublicControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AuctionProducts;
use Auth;
use App\Bids;
use App\User;
class BuyingController extends Controller
{
    public function buy(){
        $products = AuctionProducts::where('user_id','!=',Auth::user()->id)->where('sold',0)->where('approved',1)->where('end_date_time','>=',date('Y-m-d H:m',time()))->get();
        return view('buyProducts')->with('products',$products);
    }
    public function buyProduct($id){
        $product = AuctionProducts::findOrFail($id);
    	if ($product->isValidForBid()) {
    		return view('productView')->with('product',$product);
    	}
    	else{
    		return abort(404);
    	}
    	
    }
    public function bidProduct($id,Request $request){
        $product = AuctionProducts::findOrFail($id);
        if ($product->isValidForBid()) {
            ($product->isBidden())?$minPrice=$product->maxBid()+10:$minPrice=$product->minimal_price;
            $validate = \Validator::make($request->all(),[
                    'price'=>'required|numeric|min:'.$minPrice,
                ],
                [
                'price.required' => 'Please enter price to bid this product',
                'price.numeric' => 'Please enter valid price (must be numeric value)',
                'price.min' => 'Please enter price that is greater or equal to '.$minPrice,
                ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate->errors());
                //return print($validate->errors()->first());
            }
        	if ($product->hasBidden()) {
                $prevBid = $product->userBid();
                $prevBid->price = $request->input('price');
                $prevBid->save();
                return redirect()->back()->with('message','Your rebid has been successfully submitted');
        		
        	}
        	else{
        		$bid = new Bids();
                $bid->user_id = Auth::user()->id;
                $bid->product_id = $id;
                $bid->price = $request->input('price');
                $bid->save();
                return redirect()->back()->with('message','Your bid has been successfully submitted');
        	}
        }
        else{
            abort(404);
        }
    	
    }
}
