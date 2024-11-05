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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();  // Set the id as a UUID
            $table->string('username')->unique();  // Unique username for the user
            $table->string('name')->nullable();  // User's name
            $table->string('email')->unique();  // Unique email for login
            $table->uuid('employee_id')->nullable(); // Foreign key for employees
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null'); // Set null on delete
            $table->uuid('client_id')->nullable(); // Foreign key for clients
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null'); // Set null on delete
            $table->timestamp('email_verified_at')->nullable();  // Timestamp for email verification
            $table->string('password');  // Password for user authentication
            $table->rememberToken();  // Token for "remember me" functionality
            $table->timestamps();  // Created_at and updated_at timestamps
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();  // Email associated with the token, set as primary key
            $table->string('token');  // Token for password reset
            $table->timestamp('created_at')->nullable();  // Timestamp for when the token was created
            $table->timestamp('expires_at')->nullable();  // Optional: Add expiration time for security
        });


        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();  // Unique session ID
            $table->uuid('user_id')->nullable();  // Change to UUID for user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->index();  // Foreign key for users
            $table->string('ip_address', 45)->nullable();  // Store IP addresses with room for IPv6
            $table->text('user_agent')->nullable();  // User agent string for tracking
            $table->longText('payload');  // Payload data associated with the session
            $table->integer('last_activity')->index();  // Timestamp of the last activity in the session
            $table->timestamps();  // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};