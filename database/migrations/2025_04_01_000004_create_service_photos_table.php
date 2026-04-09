<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePhotosTable extends Migration
{
    public function up()
    {
        Schema::create('service_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('service_orders')->onDelete('cascade');
            $table->string('image');
            $table->string('description')->nullable();
            $table->string('stage')->default('received'); // received, diagnosis, repaired
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_photos');
    }
}
