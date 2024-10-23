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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key
            $table->string('name'); // Project name
            $table->text('description')->nullable(); // Project description
            $table->uuid('client_id'); // Foreign key for clients
            $table->date('start_date')->nullable(); // Project start date
            $table->date('end_date')->nullable(); // Project end date
            $table->enum('status', ['active', 'completed', 'on_hold'])->default('active'); // Project status
            $table->timestamps(); // Created at and Updated at timestamps

            // Foreign key constraint
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
