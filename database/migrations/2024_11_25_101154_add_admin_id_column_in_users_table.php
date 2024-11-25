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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('administrator_id')->nullable(); // Foreign key for administrators
            $table->foreign('administrator_id')->references('id')->on('administrators')->onDelete('set null'); // Set null on delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['administrator_id']); // Drop the foreign key constraint
            $table->dropColumn('administrator_id');    // Remove the column
        });
    }

};
