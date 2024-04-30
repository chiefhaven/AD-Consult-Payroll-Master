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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->decimal('employee_no');
            $table->char('prefix');
            $table->string('fname');
            $table->char('mname');
            $table->string('sname');
            $table->char('phone')->nullable();
            $table->char('phone2')->nullable();
            $table->char('current_address');
            $table->char('permanent_address');
            $table->date('hiredate')->nullable();
            $table->char('education_level');
            $table->char('workdept_id')->nullable();
            $table->char('designation_id')->nullable();
            $table->char('id_type');
            $table->char('id_number');
            $table->char('id_proof');
            $table->char('marital_status');
            $table->char('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->decimal('salary')->nullable();
            $table->decimal('bonus')->nullable();
            $table->char('status');
            $table->char('contact_id');
            $table->char('client_id');
            $table->char('com')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
