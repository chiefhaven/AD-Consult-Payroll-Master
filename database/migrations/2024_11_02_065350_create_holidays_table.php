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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the holiday
            $table->date('date'); // Full date for one-time holidays or first occurrence for recurring holidays
            $table->boolean('recurring')->default(false); // Indicates if the holiday recurs annually
            $table->string('type')->nullable(); // Optional category, e.g., "Public Holiday"
            $table->text('description')->nullable(); // Additional details if needed
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
