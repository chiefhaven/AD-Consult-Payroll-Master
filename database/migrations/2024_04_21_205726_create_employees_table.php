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
            $table->char('phone');
            $table->char('phone2');
            $table->char('current_address');
            $table->char('permanent_address');
            $table->date('hiredate');
            $table->char('education_level');
            $table->char('workdept_id');
            $table->char('designation_id');
            $table->char('id_type');
            $table->char('id_number');
            $table->char('id_proof_pic');
            $table->enum('marital_status',['Single','Married','Divorced','Widowed','Separated', 'Unknown']);
            $table->enun('gender',['Male','Female','Other']);
            $table->date('birthdate');
            $table->decimal('salary');
            $table->decimal('bonus');
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
