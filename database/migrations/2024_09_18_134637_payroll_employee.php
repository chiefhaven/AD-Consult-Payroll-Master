<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_employee', function (Blueprint $table) {
            $table->uuid('employee_id')->nullable();
            $table->uuid('payroll_id')->nullable();
            $table->decimal('salary', 15, 2);  // Increased precision for monetary values
            $table->string('pay_period', 255);
            $table->string('earning_description', 255)->nullable();
            $table->decimal('earning_amount', 15, 2)->nullable();  // Increased precision for monetary values
            $table->string('deduction_description', 255)->nullable();
            $table->decimal('deduction_amount', 15, 2)->nullable();  // Increased precision for monetary values
            $table->decimal('payee', 15, 2)->nullable();  // Increased precision for monetary values
            $table->decimal('net_salary', 15, 2)->nullable();  // Increased precision for monetary values
            $table->decimal('total_paid', 15, 2)->nullable();  // Increased precision for monetary values

            // Foreign key constraints
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('payroll_id')->references('id')->on('payrolls')->onDelete('cascade');

            // Composite primary key
            $table->primary(['employee_id', 'payroll_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_employee');
    }
};
