<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeProductFields2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sifradobavljaca')->default('nije unesena vrijednost');
            $table->integer('kategorija')->default(0);
            $table->integer('subkategorija')->default(0);
            $table->integer('proizvodjac')->default(0);
            $table->string('brojmodela')->default('nije unesena vrijednost');
            $table->string('naslovweb')->default('nije unesena vrijednost');
            $table->string('podnaslovweb')->default('nije unesena vrijednost');
            $table->longText('opis');          
            $table->text('tehnckekar');
            $table->string('dimenizije')->default('nije unesena vrijednost');
            $table->string('snaga')->default('nije unesena vrijednost');
            $table->string('napon')->default('nije unesena vrijednost');
            $table->string('zapremina')->default('nije unesena vrijednost');
            $table->string('duzinakabla')->default('nije unesena vrijednost');
            $table->string('tezina')->default('nije unesena vrijednost');
            $table->string('periodgarancije')->default('nije unesena vrijednost');
            $table->string('porukagarancija')->default('nije unesena vrijednost');
             $table->string('videoproizvoda')->default('nije unesena vrijednost');
            $table->integer('kolicina')->default(0);
            $table->decimal('pjcijena', 8, 2)->default(0);
            $table->decimal('starapjcijena', 8, 2)->default(0);
            $table->decimal('shopcijena', 8, 2)->default(0);
            $table->decimal('mincijena', 8, 2)->default(0);
            $table->integer('fixcijena')->default(0);
            $table->integer('otvoritiprije')->default(0);
            $table->text('posebnanapomena');
            $table->text('napomenazasop');
            $table->text('porukatovarni');
            $table->text('predlozenimreze');
            $table->string('linkproizvodjaca')->default('nije unesena vrijednost');
            $table->integer('premium')->default(0);
            $table->string('lokacijausklad')->default('nije unesena vrijednost')->nullable();
            $table->text('porukazasop');
            $table->integer('state')->default(0);
            $table->bigInteger('us_id')->unsigned()->nullable(); 
            $table->timestamps();
 
        });

        Schema::table('products', function($table) {
            $table->foreign('us_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
                Schema::dropIfExists('products');

    }
}
