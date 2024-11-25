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
        Schema::create('administrators', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key using UUID
            $table->string('first_name'); // Admin's first name
            $table->string('middle_name')->nullable(); // Admin's middle name (optional)
            $table->string('sirname'); // Admin's last name or surname
            $table->string('profile_picture')->nullable(); // Path or URL for the profile picture
            $table->string('phone')->nullable(); // Admin's primary phone number
            $table->string('alt_phone')->nullable(); // Admin's alternative phone number
            $table->string('street_address')->nullable(); // Admin's street address
            $table->string('district')->nullable(); // Admin's district
            $table->string('country')->nullable(); // Admin's country
            $table->string('department')->nullable(); // Department the admin belongs to
            $table->string('role')->default('admin'); // Role (e.g., admin, super_admin)
            $table->boolean('is_active')->default(true); // Status: active or inactive
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrators');
    }
};
