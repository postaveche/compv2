<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('banner_blocks', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('link');
            $table->unsignedInteger('sort_order')->default(0)->after('active');
        });
    }

    public function down()
    {
        Schema::table('banner_blocks', function (Blueprint $table) {
            $table->dropColumn(['active', 'sort_order']);
        });
    }
};
