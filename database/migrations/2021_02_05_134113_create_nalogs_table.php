<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nalogs', function (Blueprint $table) {
            $table->id();
            $table->integer('vozila');
            $table->string('vozac1');
            $table->string('vozac2')->nullable();
            $table->text('uvoznocarinjenje')->nullable();
            $table->string('proizvodjac')->nullable();
            $table->string('prikolica')->nullable();
            $table->string('polaziste')->nullable();
            $table->integer('placena')->default(0);
            $table->string('naziv');
            $table->text('napomene')->nullable();
            $table->string('kontakt')->nullable();
            $table->string('kompanija')->nullable();
            $table->string('kamion')->nullable();
            $table->text('izvoznocarinjenje')->nullable();
            $table->decimal('iznoskm',8,2)->default(0.00);
            $table->decimal('iznoseur',8,2)->default(0.00);
            $table->text('grprelaz')->nullable();
            $table->string('gmaplink')->nullable();
            $table->date('datumutovara');
            $table->string('brfak')->default('nema podataka');
            $table->integer('status')->default(0);
            $table->string('hash')->nullable();
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
        Schema::dropIfExists('nalogs');
    }
}
