<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  
        Schema::table('users', function (Blueprint $table) {
            $table->string('userRole')->default("8144a36f88b8c47153a0db9fb1619d101")->after('id');
            $table->string('about')->default("Korisnik nije unio podatke")->after('userRole');
            $table->string('photoURL')->default("/images/portrait/default.jpg")->after('about');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('userRole');
            $table->dropColumn('about');
            $table->dropColumn('photoURL');
        });
    }
}
