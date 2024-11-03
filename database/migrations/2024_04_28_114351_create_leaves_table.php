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
        Schema::create('leaves', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Define id as a UUID and set it as the primary key
            $table->uuid('employee_id'); // Define employee_id as a UUID
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade'); // Link to employees table
            $table->string('leave_type'); // Type of leave (sick, vacation, etc.)
            $table->date('start_date'); // Start date of the leave
            $table->date('end_date'); // End date of the leave
            $table->date('approval_date')->nullable(); // Approval date of the leave, nullable
            $table->uuid('approval_by')->nullable(); // UUID of the user who approved the leave, nullable
            $table->text('reason')->nullable(); // Reason for the leave, nullable
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status of the leave
            $table->timestamps(); // Timestamps for created_at and updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
