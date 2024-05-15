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
        Schema::create('benefits', function (Blueprint $table) {
            $table->id();
            $table->char('employee_id');
            $table->enum('type',['Health','Life','Retirement','Other']);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('coverage_level',['Individual','Family']);
            $table->char('provider');
            $table->char('provider_phone_number');
            $table->string('provider_email')->unique();
            $table->decimal('employee_premium');
            $table->decimal('employer_contribution')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefits');
    }
};
