<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;	

class Bids extends Model
{
    protected $table = "bids";
	public function hisBid($productId){
		return $this->where('user_id',Auth::user()->id)->where('product_id',$productId)->get()->first();
	}
	public function user(){
		return $user= $this->hasOne('App\User','id','user_id')->get()->first();
	}
	public function date()
    {
        return date('d<\s\u\p>S</\s\u\p>, F Y \a\t h:i A',strtotime($this->created_at));
    }
}
