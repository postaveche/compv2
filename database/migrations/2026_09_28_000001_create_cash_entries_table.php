<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('cash_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('service_clients')->nullOnDelete();
            $table->foreignId('service_order_id')->nullable()->constrained('service_orders')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('client_name');
            $table->string('description', 500);
            $table->decimal('amount', 12, 2);
            $table->string('payment_method', 20);
            $table->dateTime('paid_at')->index();
            $table->string('source_type', 20)->default('manual');
            $table->string('source_key')->nullable()->unique();
            $table->dateTime('voided_at')->nullable();
            $table->string('void_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_entries');
    }
}
