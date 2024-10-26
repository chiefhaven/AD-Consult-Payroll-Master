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
            // $table->uuid('id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->text('client_name');
            $table->float('total_amount');
            $table->float('discount');
            $table->float('paid_amount');
            $table->enum('bill_type', ['invoice', 'quotation']);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->enum('discount_type', ['loyalty', 'trade', 'no discount'])->default('no discount');
            $table->float('balance');
            $table->float('tax_amount');
            // $table->string('product');
            // $table->integer('quantity');
            // $table->float('rate');
            $table->string('discription')->nullable();
            $table->string('transaction_terms');
            $table->date('issue_date');
            $table->date('due_date')->nullable();
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
