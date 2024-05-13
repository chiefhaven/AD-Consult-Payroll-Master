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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->char('employee_id');
            $table->char('client_id');
            $table->char('fname');
            $table->char('lname');
            $table->char('email_address');
            $table->char('phone_number');
            $table->char('country');
            $table->char('city');
            $table->char('state')->nullable();
            $table->char('street')->nullable();
            $table->char('postal_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
