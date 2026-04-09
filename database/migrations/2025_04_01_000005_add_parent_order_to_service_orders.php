<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentOrderToServiceOrders extends Migration
{
    public function up()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->boolean('is_return')->default(false)->after('notes');
            $table->unsignedBigInteger('parent_order_id')->nullable()->after('is_return');
            $table->foreign('parent_order_id')->references('id')->on('service_orders')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropForeign(['parent_order_id']);
            $table->dropColumn(['is_return', 'parent_order_id']);
        });
    }
}
