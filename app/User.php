<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Bids;
use Auth;
class User extends Authenticatable
{
    use  HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname','phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function isAdmin(){
        if ($this->user_type=="admin") {
            return true;
        }
        else{
            return false;
        }
    }
    public function isRegular(){
        if ($this->user_type=="regular") {
            return true;
        }
        else{
            return false;
        }
    }
    public function hasBidden($productId){
        if(Bids::where('user_id',Auth::user()->id)->where('product_id',$productId)->get()->count()==1){
            return true;
        }
        return false;
    }
    public function auctions($id=null){
        if ($id==null) {
            return $this->hasMany('App\AuctionProducts','user_id','id')->get();
        }
        return $this->hasMany('App\AuctionProducts','user_id','id')->where('id',$id)->firstOrFail();
    }
}
