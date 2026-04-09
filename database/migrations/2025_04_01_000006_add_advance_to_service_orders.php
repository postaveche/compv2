<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdvanceToServiceOrders extends Migration
{
    public function up()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->decimal('advance_payment', 10, 2)->default(0)->after('final_price');
        });
    }

    public function down()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropColumn('advance_payment');
        });
    }
}
