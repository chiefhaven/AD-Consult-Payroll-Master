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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['invoice','quotation','receipt']);            
            $table->unsignedBigInteger('client_id');
            $table->decimal('amount',15,2);
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->text('description')->nullable();
            $table->enum('status',['pending','paid','cancelled'])->default('pending');
            $table->timestamps();
              
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};