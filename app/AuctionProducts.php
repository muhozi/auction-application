<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class AuctionProducts extends Model
{
    protected $table= "auctionproducts";
    protected $diff = 10;
    public function getProductNameAttribute($value)
    {
        return ucfirst($value);
    }
    protected $casts = [
        'approved' => 'boolean',
        'sold' => 'boolean',
    ];
    public function endDate()
    {
        return date('l d<\s\u\p>S</\s\u\p>, F Y \a\t h:i A',strtotime($this->end_date_time));
    }
    public function user(){
    	$user = $this->belongsTo('\App\User','user_id','id')->get()->first();
    	return $names = $user->firstname.' '.$user->lastname;
    }
    public function isValidForBid(){
        if ((strtotime($this->end_date_time) > time()) && $this->sold==0 && $this->user_id != Auth::user()->id) {
            return true;
        }
        return false;
    }
    public function bidPrice(){
        return $min = $this->highestBid()+$this->diff;
    }
    public function isEnded(){
        if (strtotime($this->end_date_time) < time()) {
            return true;
        }
        return false;
    }
    public function bids(){
        return $this->hasMany('App\Bids','product_id','id')->orderBy('price','desc')->get();
    }
    public function userBid(){
        return $this->hasMany('App\Bids','product_id','id')->where('user_id',Auth::user()->id)->get()->first();
    }
    public function apiUserBid($id){
        return $this->hasMany('App\Bids','product_id','id')->where('user_id',$id)->get()->first();
    }
    public function bidsCount(){
        return $this->hasMany('App\Bids','product_id','id')->get()->count();
    }
    public function highestBid(){
        return $this->hasMany('App\Bids','product_id','id')->get()->max('price');
    }
    public function isBidden(){
        if($this->hasMany('App\Bids','product_id','id')->get()->count()>0){
            return true;
        }
        else{
            return false;
        }
    }
    public function maxBid(){
        return $this->hasMany('App\Bids','product_id','id')->get()->max('price');
    }
    public function maxBidDetails(){
        return $this->hasMany('App\Bids','product_id','id')->where('price',$this->maxBid())->get()->first();
    }
    public function hasBidden(){
        if ($this->hasMany('App\Bids','product_id','id')->where('user_id',Auth::user()->id)->get()->count()==1) {
            return true;
        }
        return false;
    }
    public function apiHasBidden($id){
        if ($this->hasMany('App\Bids','product_id','id')->where('user_id',$id)->get()->count()==1) {
            return true;
        }
        return false;
    }
}
