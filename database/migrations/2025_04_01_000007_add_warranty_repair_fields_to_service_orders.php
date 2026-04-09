<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarrantyRepairFieldsToServiceOrders extends Migration
{
    public function up()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->boolean('is_warranty_repair')->default(false)->after('is_return');
            $table->string('cancel_reason')->nullable()->after('is_warranty_repair');
            $table->decimal('diagnosis_fee', 10, 2)->default(0)->after('cancel_reason');
            $table->boolean('diagnosis_fee_paid')->default(false)->after('diagnosis_fee');
        });
    }

    public function down()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropColumn(['is_warranty_repair', 'cancel_reason', 'diagnosis_fee', 'diagnosis_fee_paid']);
        });
    }
}
