<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('name_ro', 255);
            $table->string('name_ru', 255);
            $table->string('description', 255)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->string('slug', 255)->unique();
            $table->string('sku', 50);
            $table->integer('b2b_code')->nullable();
            $table->string('img_thumb', 255)->default('/logo.png');
            $table->string('img', 255)->nullable();
            $table->integer('img_qty')->default('0');
            $table->string('text', 3000)->nullable();
            $table->float('price', 8, 2);
            $table->string('special_price', '10')->nullable();
            $table->string('gift', 10)->nullable();
            $table->integer('garantie')->default('12');
            $table->text('product_info')->nullable();
            $table->integer('category_id')->default('0');
            $table->integer('b2b_parentcode')->nullable();
            $table->integer('user_id');
            $table->integer('atribute_id')->default('0');
            $table->integer('active')->default('0');
            $table->integer('b2b_transaction_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
