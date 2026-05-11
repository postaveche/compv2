<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingPackagesTable extends Migration
{
    public function up()
    {
        Schema::create('hosting_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('currency', ['EUR', 'USD', 'MDL'])->default('MDL');
            $table->string('period')->default('anual');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hosting_packages');
    }
}
