<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KompanijaChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kompanijas', function (Blueprint $table) {
        $table->string('kontakt')->default('nije uneseno'); 
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kompanijas', function($table) {    
            $table->dropColumn('kontakt');
        }); 
    }
}