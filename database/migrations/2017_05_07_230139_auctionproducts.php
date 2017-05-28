<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Auctionproducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctionproducts', function (Blueprint $table) {
            //[productName] => Tv Set [minimalPrice] => 40000 [auctionEndDate] => 21/05/2017 [auctionEndTime] => 00:00 [productPicture] => vlcsnap-2017-04-28-22h55m49s815.png [description] => jbsdhjasv asdhjbsad asjdh asdas )
            $table->increments('id');
            $table->integer('user_id');
            $table->string('product_name',255);
            $table->string('minimal_price',60);
            $table->string('end_date_time',100);
            $table->string('picture',255);
            $table->longText('description');
            $table->integer('sold')->default(0);
            $table->integer('approved')->default(0);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctionproducts');
    }
}
