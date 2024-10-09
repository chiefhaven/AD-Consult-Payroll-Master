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
            $table->float('quotation_amount');
            $table->float('invoice_amount');
            $table->float('discount');
            $table->float('paid_amount');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->float('balance');
            $table->float('amount_before_tax');
            $table->float('tax_amount');
            $table->string('discount_type');
            $table->string('transaction_terms');
            $table->string('discription')->nullable();
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('client_id');
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