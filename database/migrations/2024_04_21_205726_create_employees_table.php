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
            $table->char('employee_no');
            $table->char('prefix')->nullable();
            $table->string('fname');
            $table->char('mname')->nullable();
            $table->string('sname');
            $table->char('phone');
            $table->char('phone2')->nullable();
            $table->char('current_address');
            $table->char('permanent_address')->nullable();
            $table->date('hiredate');
            $table->enum('education_level', ['PhD', 'MSC', 'BSC', 'MSCE/GSCE', 'JCE', 'Other'])->default('BSC');
            $table->char('workdept_id');
            $table->char('designation_id');
            $table->enum('id_type', ['Malawi National ID', 'Passport', 'Driving Licence', 'Other'])->default('Malawi National ID');
            $table->char('id_number');
            $table->char('id_proof_pic');
            $table->enum('marital_status', ['Married', 'Single', 'Widow', 'Divorced', 'Other'])->default('Single');
            $table->enum('gender', ['Male', 'Female', 'Other', 'Them']);
            $table->date('birthdate');
            $table->decimal('salary');
            $table->decimal('bonus');
            $table->enum('status', ['Pending', 'Active', 'Contract terminated', 'Contract ended', 'Suspended', 'On Probation'])->default('Pending');
            $table->char('contact_id');
            $table->char('client_id');
            $table->char('tax1')->nullable();
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
