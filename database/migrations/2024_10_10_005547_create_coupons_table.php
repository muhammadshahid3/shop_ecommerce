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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->text('coupon_code')->nullable();
            $table->float('coupon_amount')->nullable();
            $table->integer('number_of_uses')->nullable();
            $table->integer('coupon_stock')->nullable();
            $table->integer('limit_per_uses')->nullable();
            $table->date('coupon_start_date')->nullable();
            $table->date('coupon_end_date')->nullable();
            $table->enum('coupon_status',['A','I'])->default('I');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
