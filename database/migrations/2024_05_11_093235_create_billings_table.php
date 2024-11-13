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
            // Define primary key as UUID
            $table->uuid('id')->primary();

            // Define client_id as UUID and add foreign key constraint
            $table->uuid('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->enum('billing_type', ['quotation', 'invoice']);

            // Reference numbers and currency
            $table->string('invoice_number')->unique();
            $table->string('currency', 3)->default('MK');

            // Financial fields
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('discount', 15, 2)->default(0);
            $table->enum('discount_type', ['percentage', 'fixed'])->default('fixed');

            // Tax fields
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->boolean('tax_inclusive')->default(false);

            // Date fields
            $table->date('billing_date')->nullable();
            $table->integer('paymentTerms')->nullable()->default(0);
            $table->enum('termsUnits', ['Days', 'Months'])->nullable();

            // Additional charges
            $table->decimal('shipping_amount', 15, 2)->nullable();
            $table->decimal('other_charges', 15, 2)->nullable();

            // Recurrence and fees
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_period', ['weekly', 'monthly', 'yearly'])->nullable();
            $table->decimal('late_fee', 15, 2)->default(0);
            $table->decimal('penalty_rate', 5, 2)->default(0);

            // Additional info
            $table->text('transaction_terms')->nullable();
            $table->text('notes')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();

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
        Schema::dropIfExists('billings');
    }
};
