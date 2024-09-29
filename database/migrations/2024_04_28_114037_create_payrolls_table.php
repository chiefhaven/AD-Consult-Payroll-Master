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
            $table->uuid('id')->primary();  // Unique identifier for payroll using UUID
            $table->string('group');  // Grouping field for payroll (can be department, batch, etc.)
            $table->uuid('client_id');  // Foreign key for client (likely referencing clients table)
            $table->integer('total_amount');  // Total payroll amount
            $table->integer('total_deductions');  // Total payroll deductions
            $table->integer('total_payee');  // Total Pay As You Earn (PAYE) deductions
            $table->enum('status', ['Draft', 'Approved', 'Pending Approval', 'Cancelled', 'Final']);  // Status of payroll
            $table->timestamps();  // Created_at and updated_at timestamps
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
