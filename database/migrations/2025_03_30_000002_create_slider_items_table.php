<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('slider_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_id')->constrained('sliders')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('description')->nullable();
            $table->string('description_ru')->nullable();
            $table->string('image');
            $table->string('link')->nullable();
            $table->integer('active')->default(1);
            $table->integer('sort_order')->default(0);
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slider_items');
    }
}
