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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('order_slug',100)->nullable();
            $table->integer('order_product')->nullable();
            $table->text('order_number')->nullable();
            $table->integer('order_subtotal_qty')->nullable();
            $table->float('order_total_price')->nullable();
            $table->text('coupon_code')->nullable();
            $table->float('discount_value')->nullable();
            $table->enum('discount_type',['V','P','N'])->default('N');
            $table->float('shipping_charges')->nullable();
            $table->enum('shipping_status',['F','N'])->default('N');
            $table->float('order_net_total')->nullable();
            $table->enum('order_highlight',['A','I'])->default('I');
            $table->enum('order_alert',['A','I'])->default('I');
            $table->enum('payment_method',['PBC','COD','N'])->default('N');
            $table->enum('order_delivery_type',['C','D'])->default('C');
            $table->enum('order_status',['P','U'])->default('U');
            $table->date('order_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
