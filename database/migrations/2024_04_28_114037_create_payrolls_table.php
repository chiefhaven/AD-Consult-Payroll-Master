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
            $table->foreignId('employee_id');
            $table->date('payment_date');
            $table->enum('pay_period',['Weekly','Bi weekly','Monthly']);
            $table->decimal('gross_pay');
            $table->decimal('net_pay');
            $table->decimal('deductions');
            $table->enum('compansation',['salary','wage','commision','bonus']);
            $table->enum('payment_method',['Direct Deposit','Check']);
            $table->enum('payment_status',['completed ','pending','']);
            $table->timestamps();
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