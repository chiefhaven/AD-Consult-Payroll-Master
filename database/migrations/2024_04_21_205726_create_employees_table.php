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
            $table->string('family_contact_name');
            $table->char('family_contact_number');
            $table->char('family_contact_alt_number')->nullable();
            $table->char('phone');
            $table->char('employee_alt_number')->nullable();
            $table->char('nationality_id')->nullable();
            $table->char('current_state');
            $table->char('current_city');
            $table->char('current_street');
            $table->char('permanent_state');
            $table->char('permanent_city');
            $table->char('permanent_street');
            $table->date('hiredate');
            $table->enum('education_level', ['PhD', 'MSC', 'BSC', 'MSCE/GSCE', 'JCE', 'Other'])->default('BSC');
            $table->enum('designated_location', ['Lilongwe', 'Salima']);
            $table->char('workdept_id');
            $table->char('designation_id');
            $table->string('designated_location_specifics');
            $table->integer('termination_notice_period')->default(0);
            $table->enum('termination_notice_period_type',['Days', 'Weeks', 'Months']);
            $table->enum('id_type', ['Malawi National ID', 'Passport', 'Driving Licence', 'Other'])->default('Malawi National ID');
            $table->char('id_number');
            $table->char('id_proof_pic')->nullable();
            $table->enum('marital_status',['Married', 'Single', 'Widow', 'Divorced', 'Other']);
            $table->enum('contract_type',['Permanent', 'Part time']);
            $table->enum('gender',['Male', 'Female', 'Other', 'Them']);
            $table->date('birthdate')->nullable();
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->decimal('salary')->nullable();
            $table->decimal('bonus')->nullable();
            $table->decimal('basic_pay');
            $table->decimal('tax');
            $table->enum('pay_period', ['Hourly', 'Daily', 'Weekly', 'Bi Weekly', 'Monthly']);
            $table->enum('status', ['Pending', 'Active', 'Contract terminated', 'Contract ended', 'Suspended', 'On Probation'])->default('Pending');
            $table->char('client_id');
            $table->char('contact_id');
            $table->char('tax1')->nullable();
            $table->char('company');
            $table->char('project');
            $table->char('probation_period');
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
