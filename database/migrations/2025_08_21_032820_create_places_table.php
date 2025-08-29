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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable(); // Optional: if you want to categorize places
            $table->string('address')->nullable(); // Optional: if you want to store an address
            $table->string('phone')->nullable(); // Optional: if you want to store a phone number
            $table->string('website')->nullable(); // Optional: if you want to store a website URL
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Optional: if you want to store an image path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
