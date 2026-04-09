<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('translate_settings', function (Blueprint $table) {
            $table->id();
            $table->string('deepl_api_key')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('translate_settings');
    }
}
