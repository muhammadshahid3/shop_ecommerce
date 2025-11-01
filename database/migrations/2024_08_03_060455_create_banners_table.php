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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->text('banner_start_text')->nullable();
            $table->text('banner_title')->nullable();
            $table->text('banner_sub_title')->nullable();
            $table->text('banner_image')->nullable();
            $table->text('banner_btn_link')->nullable();
            $table->enum('banner_status',['A','I'])->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
