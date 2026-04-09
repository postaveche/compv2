<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceClientsTable extends Migration
{
    public function up()
    {
        Schema::create('service_clients', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('fizica'); // fizica sau juridica
            $table->string('name');
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            // Doar pentru juridica
            $table->string('company')->nullable();
            $table->string('idno')->nullable();
            $table->string('cod_fiscal')->nullable();
            $table->string('cont_bancar')->nullable();
            $table->string('banca')->nullable();
            $table->string('adresa_juridica')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_clients');
    }
}
