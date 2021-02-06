<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtovarIstovarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utovar_istovars', function (Blueprint $table) {
            $table->id();
            $table->integer('nalog_id');
            $table->integer('vozila');
            $table->string('adresa');
            $table->string('grad');
            $table->string('drzava');
            $table->text('napomena')->nullable();
            $table->integer('tip')->default(0);
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
        Schema::dropIfExists('utovar_istovars');
    }
}
