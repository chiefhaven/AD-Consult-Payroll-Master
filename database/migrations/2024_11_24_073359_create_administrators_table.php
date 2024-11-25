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
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Link to the users table
            $table->string('first_name'); // Admin's first name
            $table->string('sirname'); // Admin's last name or surname
            $table->text('address')->nullable(); // Admin's address
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
