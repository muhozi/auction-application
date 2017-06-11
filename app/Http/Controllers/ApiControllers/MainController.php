<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AuctionProducts;
use App\Bids;
use DB;


class MainController extends Controller
{
    public function bids(Request $request){
    	$products = AuctionProducts::where('user_id','!=',$request->user()->id)->where('sold',0)->where('approved',1)->where('end_date_time','>=',date('Y-m-d H:m',time()))->orderBy('id','desc')->get();
    	$productsArray=[];
    	foreach($products as $product){
    		$singleProductDetails = $product->toArray();
    		//Appends Additional data to our json response
    		$singleProductDetails['user']=$product->user();
    		$singleProductDetails['picture']=asset('img/products/'.$singleProductDetails['picture']);
    		$singleProductDetails['end_date_time']=date('dS M Y \a\t h:i A',strtotime($singleProductDetails['end_date_time']));
    		$singleProductDetails['bids_no']=$product->bidsCount().' '.str_plural('time',$product->bidsCount());
    		$singleProductDetails['minimal_price']='Rwf '.$product->minimal_price;
    		$singleProductDetails['high_price']='Rwf '.$product->highestBid();
            $singleProductDetails['bid_price']=$product->isBidden()?'Rwf '.$product->bidPrice():$singleProductDetails['minimal_price'];
            $singleProductDetails['is_bidden']=$product->isBidden()?true:false;
    		$productsArray[]=$singleProductDetails;
    	}
        return Response()->json($productsArray);
    }
    public function bid($id){
    	$productObj = AuctionProducts::where('id',$id)->where('sold',0)->where('approved',1)->where('end_date_time','>=',date('Y-m-d H:m',time()))->firstOrFail();
    	$product = $productObj->toArray();
    	$product['user']=$productObj->user();
    	$product['picture']=asset('img/products/'.$product['picture']);
    	$product['end_date_time']=date('dS M Y \a\t h:i A',strtotime($product['end_date_time']));
    	$product['bids_no']=$productObj->bidsCount().' '.str_plural('time',$productObj->bidsCount());
    	$product['minimal_price']='Rwf '.$productObj->minimal_price;
    	$product['high_price']='Rwf '.$productObj->highestBid();
        $product['bid_price']=$productObj->isBidden()?'Rwf '.$productObj->bidPrice():$product['minimal_price'];
        $product['is_bidden']=$productObj->isBidden()?true:false;
        return Response()->json($product);
    }
    public function myauctions(Request $request){
        $products = AuctionProducts::where('user_id',$request->user()->id)->where('sold',0)->orderBy('id','desc')->get();
        $productsArray=[];
        foreach($products as $product){
            $singleProductDetails = $product->toArray();
            //Appends Additional data to our json response
            $singleProductDetails['user']=$product->user();
            $singleProductDetails['picture']=asset('img/products/'.$singleProductDetails['picture']);
            $singleProductDetails['end_date_time']=date('dS M Y \a\t h:i A',strtotime($singleProductDetails['end_date_time']));
            $singleProductDetails['bids_no']=$product->bidsCount().' '.str_plural('time',$product->bidsCount());
            $singleProductDetails['minimal_price']='Rwf '.$product->minimal_price;
            $singleProductDetails['high_price']='Rwf '.$product->highestBid();
            $singleProductDetails['bid_price']=$product->isBidden()?'Rwf '.$product->bidPrice():$singleProductDetails['minimal_price'];
            $singleProductDetails['is_bidden']=$product->isBidden()?true:false;
            $singleProductDetails['is_ended']=$product->isEnded()?true:false;
            $singleProductDetails['high_bid_user']=(count($product->maxBidDetails())>0)?$product->maxBidDetails()->user():false;
            $productsArray[]=$singleProductDetails;
        }
        return Response()->json($productsArray);
        }
        public function user(Request $request){
            $userdata = $request->user();
            $data = $userdata->toArray();
            $data['auctions'] = (AuctionProducts::where('user_id',$userdata->id)->get()->count()>0)?AuctionProducts::where('user_id',$userdata->id)->get()->count() .' '.str_plural('Auction',AuctionProducts::where('user_id',$userdata->id)->get()->count()):'No auction';
            return Response()->json($data);
        }
        public function saveAuction(Request $request){
        $all = $request->all();
        if ($request->hasFile('productImage')) {
            $filename = str_replace(' ', '_', $request->productName)."_".$request->price."_".time().str_random(30).'.'.$request->productImage->extension();
            $request->productImage->storeAs('/img/products',$filename);
            $product = new AuctionProducts();
            $product->user_id = $request->user()->id;
            $product->product_name = $request->productName;
            $product->minimal_price = $request->price;
            $product->end_date_time = $request->endDateTime;
            $product->picture = $filename;
            $product->description = $request->description;
            $product->save();
            return Response()->json(['message'=>'Your auction details has been saved','status'=>'success']);
        }
        else{
            return $all;
        }
    }
    public function bidProduct(Request $request,$id){
        $product = AuctionProducts::findOrFail($id);
        if ($product->isValidForBid()) {
            ($product->isBidden())?$minPrice=$product->maxBid()+10:$minPrice=$product->minimal_price;
            $validate = \Validator::make($request->all(),[
                    'price'=>'required|numeric|min:'.$minPrice,
                ],
                [
                'price.required' => 'Please enter price to bid this product',
                'price.numeric' => 'Please enter valid price (must be numeric value)',
                'price.min' => "Please enter price that is greater \n or equal to Rwf ".$minPrice,
                ]);
            if ($validate->fails()) {
                return Response()->json(['status'=>'error','errors'=>$validate->errors()]);
            }
            if ($product->apiHasBidden($request->user()->id)) {
                $prevBid = $product->apiUserBid($request->user()->id);
                $prevBid->price = $request->input('price');
                $prevBid->save();
                return Response()->json(['message'=>'Your rebid has been successfully submitted','status'=>'success']);
                
            }
            else{
                $bid = new Bids();
                $bid->user_id = $request->user()->id;
                $bid->product_id = $id;
                $bid->price = $request->input('price');
                $bid->save();
                return Response()->json(['message'=>'Your bid has been successfully submitted','status'=>'success']);
            }
        }
    }
    public function logout(Request $request){
        DB::table('oauth_access_tokens')->where('user_id', '=', $request->user()->id)->update(['revoked' => true]);
        return Response()->json(['message'=>'You have logged out','status'=>'success']);
    }
}