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
            $table->boolean('is_quotation');
            $table->boolean('is_invoice');
            $table->decimal('quotation_amount');
            $table->decimal('invoice_amount');
            $table->decimal('discount');
            $table->decimal('paid_amount');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->decimal('balance');
            $table->decimal('amount_before_tax');
            $table->decimal('tax_amount');
            $table->string('discount_type');
            $table->string('transaction_terms');
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
