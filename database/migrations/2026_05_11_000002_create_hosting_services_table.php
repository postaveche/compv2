<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingServicesTable extends Migration
{
    public function up()
    {
        Schema::create('hosting_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('service_clients')->onDelete('cascade');
            $table->foreignId('hosting_package_id')->nullable()->constrained('hosting_packages')->onDelete('set null');
            $table->enum('type', ['hosting', 'domain'])->default('hosting');
            $table->string('name');
            $table->string('domain')->nullable();
            $table->string('registrar')->nullable();
            $table->string('server')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('currency', ['EUR', 'USD', 'MDL'])->default('MDL');
            $table->date('started_at')->nullable();
            $table->date('expires_at');
            $table->date('payment_due_at');
            $table->boolean('is_paid')->default(false);
            $table->boolean('active')->default(true);
            $table->date('last_notified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hosting_services');
    }
}
