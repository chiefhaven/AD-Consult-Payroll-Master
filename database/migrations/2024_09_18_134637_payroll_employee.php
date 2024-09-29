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
            $table->decimal('salary', 10, 2);
            $table->string('pay_period', 255);
            $table->string('earning_description', 255)->nullable();
            $table->decimal('earning_amount', 10, 2)->nullable();
            $table->string('deduction_description', 255)->nullable();
            $table->decimal('deduction_amount', 10, 2)->nullable();
            $table->decimal('payee', 10, 2)->nullable();
            $table->decimal('net_salary', 10, 2)->nullable();
            $table->decimal('total_paid', 10, 2)->nullable();

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
