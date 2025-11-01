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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('shop_logo',100)->nullable();
            $table->string('shop_name',100)->nullable();
            $table->string('email',100)->nullable();
            $table->string('contact',100)->nullable();
            $table->text('address')->nullable();
            $table->longText('description')->nullable();
            $table->enum('notification', ['A','I'])->default('I');
            $table->enum('status', ['A','I'])->default('A');
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('twitter')->nullable();
            $table->enum('order_delivery_time',['C','D'])->default('Delivery');
            $table->float('shipping_charges')->default(null);
            $table->enum('shipping_status', ['F','N'])->default('N');
            $table->enum('pay_by_delivery',['A','I'])->default('I');
            $table->enum('pay_by_card',['A','I'])->default('I');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
