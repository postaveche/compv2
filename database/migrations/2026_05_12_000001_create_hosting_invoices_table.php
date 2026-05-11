<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('hosting_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('hosting_service_id')->constrained('hosting_services')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('service_clients')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->default(0);
            $table->enum('currency', ['EUR', 'USD', 'MDL'])->default('MDL');
            $table->date('issued_at');
            $table->date('due_at');
            $table->date('service_expires_at');
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');
            $table->date('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['hosting_service_id', 'service_expires_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('hosting_invoices');
    }
}
