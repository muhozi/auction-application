<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AuctionProducts;

class MainController extends Controller
{
    public function bids(){
    	$products = AuctionProducts::where('sold',0)->where('approved',1)->where('end_date_time','>=',date('Y-m-d H:m',time()))->get();
    	$productsArray=[];
    	foreach($products as $product){
    		$singleProductDetails = $product->toArray();
    		//Appends Additional data to our json response
    		$singleProductDetails['user']=$product->user();
    		$singleProductDetails['picture']=asset('img/products/'.$singleProductDetails['picture']);
    		$singleProductDetails['end_date_time']=date('dS M Y \a\t h:i A',strtotime($singleProductDetails['end_date_time']));
    		$singleProductDetails['bids_no']=$product->bidsCount();
    		$singleProductDetails['minimal_price']='Rwf '.$product->minimal_price;
    		$singleProductDetails['high_price']='Rwf '.$product->highestBid();
            $singleProductDetails['bid_price']=$product->isBidden()?'Rwf '.$product->bidPrice():$singleProductDetails['minimal_price'];
            $singleProductDetails['is_bidden']=$product->isBidden()?true:false;
    		$productArray[]=$singleProductDetails;
    	}
        return Response()->json($productArray);
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
    public function myauctions(){
        $products = AuctionProducts::where('sold',0)->where('approved',1)->where('end_date_time','>=',date('Y-m-d H:m',time()))->get()->take(2);
        $productsArray=[];
        foreach($products as $product){
            $singleProductDetails = $product->toArray();
            //Appends Additional data to our json response
            $singleProductDetails['user']=$product->user();
            $singleProductDetails['picture']=asset('img/products/'.$singleProductDetails['picture']);
            $singleProductDetails['end_date_time']=date('dS M Y \a\t h:i A',strtotime($singleProductDetails['end_date_time']));
            $singleProductDetails['bids_no']=$product->bidsCount();
            $singleProductDetails['minimal_price']='Rwf '.$product->minimal_price;
            $singleProductDetails['high_price']='Rwf '.$product->highestBid();
            $singleProductDetails['bid_price']=$product->isBidden()?'Rwf '.$product->bidPrice():$singleProductDetails['minimal_price'];
            $singleProductDetails['is_bidden']=$product->isBidden()?true:false;
            $productArray[]=$singleProductDetails;
        }
        return Response()->json($productArray);
    }
}
