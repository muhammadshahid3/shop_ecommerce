<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_slug',100)->nullable();
            $table->string('product_code',20)->nullable();
            $table->text('product_barcode')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('product_name',50)->nullable();
            $table->float('product_old_price')->nullable();
            $table->float('product_price')->nullable();
            $table->text('product_thumbnail')->nullable();
            $table->text('product_description')->nullable();
            $table->text('product_manufacturer')->nullable();
            $table->text('product_supplier')->nullable();
            $table->text('product_weight')->nullable();
            $table->text('product_order')->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->enum('product_stock_status',['A','I'])->default('A');
            $table->enum('product_status',['A','I'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
