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
        Schema::create('customer_details', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('username',15)->nullable();
            $table->string('email',20)->nullable();
            $table->string('phone_number',15)->nullable();
            $table->text('house_no')->nullable();
            $table->string('street',100)->nullable();
            $table->string('city',150)->nullable();
            $table->string('postcode',15)->nullable();
            $table->longText('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_details');
    }
};
