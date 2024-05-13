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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->char('username');
            $table->string('password');
            $table->char('fname');
            $table->char('mname')->nullable();
            $table->char('lname');
            $table->string('email')->unique();
            $table->char('phone_number');
            $table->enum('role',['superadmin','human_resource_admin','finance_admin']);
            $table->boolean('status');
            $table->char('profile_picture');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
