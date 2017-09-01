<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(Schema::hasTable('auctionproducts')){
            View::share("unproved",\App\AuctionProducts::where('approved',0)->get()->count());
            View::share("noAuctions",\App\AuctionProducts::all()->count());
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
