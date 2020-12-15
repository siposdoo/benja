<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::table('products', function($table) {    
        $table->dropColumn('name');
        $table->dropColumn('shortdesc');
        $table->dropColumn('techdesc');
        $table->dropColumn('state');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function($table) {    
            
            $table->string('name');
            $table->text('shortdesc');
            $table->longText('techdesc');
            $table->integer('state');

        });
    }
}
