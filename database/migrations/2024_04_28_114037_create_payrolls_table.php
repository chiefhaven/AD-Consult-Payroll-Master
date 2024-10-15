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
            $table->string('group');  // Grouping field for payroll (e.g., department, batch)
            $table->uuid('client_id')->constrained('clients')->onDelete('cascade');  // Foreign key for client, references clients table
            $table->decimal('total_amount', 15, 2);  // Total payroll amount with decimal precision
            $table->decimal('total_deductions', 15, 2);  // Total payroll deductions with decimal precision
            $table->decimal('total_payee', 15, 2);  // Total Pay As You Earn (PAYE) deductions with decimal precision
            $table->enum('status', ['Draft', 'Approved', 'Pending Approval', 'Cancelled', 'Final'])->default('Draft');  // Status of payroll
            $table->timestamps();  // created_at and updated_at timestamps
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
