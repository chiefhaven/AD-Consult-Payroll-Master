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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('employee_id');
            $table->date('payment_date');
            $table->enum('pay_period',['Weekly','Bi weekly','Monthly']);
            $table->decimal('gross_pay');
            $table->decimal('net_pay');
            $table->decimal('total_tax_amount');
            $table->decimal('commission')->nullable();
            $table->decimal('bonus')->nullable();
            $table->decimal('health_insurance')->nullable();
            $table->decimal('other_deductions')->nullable();
            $table->enum('payment_method',['Direct Deposit','Cheque']);
            $table->enum('payment_status',['Draft','Approved','Cancelled','Paid']);
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};