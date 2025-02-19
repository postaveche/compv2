<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('name_ru', 255);
            $table->string('desc', 255);
            $table->string('desc_ru', 255);
            $table->string('image', 255);
            $table->string('link', 255);
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
        Schema::dropIfExists('banner_blocks');
    }
}
