<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('client_id')->constrained('service_clients')->onDelete('cascade');
            $table->string('device_type');
            $table->string('device_brand')->nullable();
            $table->string('device_model')->nullable();
            $table->string('serial_number')->nullable();
            $table->text('accessories')->nullable();
            $table->text('device_condition')->nullable();
            $table->text('problem_description');
            $table->text('diagnosis')->nullable();
            $table->text('work_done')->nullable();
            $table->text('parts_used')->nullable();
            $table->string('status')->default('received');
            $table->decimal('estimated_price', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('warranty')->default(false);
            $table->integer('warranty_days')->default(30);
            $table->date('estimated_completion')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->unsignedBigInteger('received_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_orders');
    }
}
