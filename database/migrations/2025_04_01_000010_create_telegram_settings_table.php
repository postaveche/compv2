<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('telegram_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bot_token')->nullable();
            $table->string('chat_id')->nullable();
            $table->boolean('notify_new_order')->default(true);
            $table->boolean('notify_status_change')->default(true);
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('telegram_settings');
    }
}
