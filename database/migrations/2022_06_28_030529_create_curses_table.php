<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curses', function (Blueprint $table) {
            $table->id();
            $table->date('datacurs');
            $table->string('usd_sell', 10);
            $table->string('usd_buy', 10);
            $table->string('ron_sell', 10);
            $table->string('ron_buy', 10);
            $table->string('uah_sell', 10);
            $table->string('uah_buy', 10);
            $table->string('eur_sell', 10);
            $table->string('eur_buy', 10);
            $table->string('chf_sell', 10);
            $table->string('chf_buy', 10);
            $table->string('gbp_sell', 10);
            $table->string('gbp_buy', 10);
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
        Schema::dropIfExists('curses');
    }
}
