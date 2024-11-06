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
        Schema::create('payments', function (Blueprint $table) {
            // Define primary key as UUID
            $table->uuid('id')->primary();

            // Define billing_id as UUID and add foreign key constraint
            $table->uuid('billing_id');
            $table->foreign('billing_id')->references('id')->on('billings')->onDelete('cascade');

            // Payment details
            $table->decimal('payment_amount', 15, 2); // The amount paid in the payment
            $table->enum('payment_method', ['cash', 'credit_card', 'bank_transfer', 'online'])->nullable(); // The payment method used
            $table->string('payment_reference')->nullable(); // A reference for the payment (transaction ID, check number, etc.)
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending'); // Status of the payment
            $table->date('payment_date')->nullable(); // The date the payment was made
            $table->string('payment_gateway')->nullable(); // If the payment was made via an online gateway, store it here
            $table->string('transaction_id')->nullable(); // A unique transaction ID for the payment
            $table->text('notes')->nullable(); // Any notes regarding the payment

            // Foreign keys for tracking creation and updates
            $table->foreignUuid('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignUuid('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
