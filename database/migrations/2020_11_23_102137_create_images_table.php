<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('urlImage'); 
            $table->uuid('product_id'); 
            $table->integer('type')->default(0);
            $table->timestamps();
        });
        Schema::table('images', function($table) {
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
