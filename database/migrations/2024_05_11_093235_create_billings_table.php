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
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->enum('billing_type', ['quotation', 'invoice']);
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('discount', 15, 2)->default(0);
            $table->enum('discount_type', ['percentage', 'fixed'])->default('fixed');
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('amount_before_tax', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->nullable();
            $table->boolean('tax_inclusive')->default(false);
            $table->decimal('shipping_amount', 15, 2)->nullable();
            $table->decimal('other_charges', 15, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->date('billing_date')->nullable();
            $table->date('payment_due_date')->nullable();
            $table->string('invoice_number')->unique()->nullable();
            $table->string('reference_number')->unique()->nullable();
            $table->string('currency', 3)->default('USD');
            $table->enum('payment_method', ['cash', 'credit_card', 'bank_transfer', 'online'])->nullable();
            $table->enum('payment_status', ['unpaid', 'partially_paid', 'paid', 'overdue'])->default('unpaid');
            $table->boolean('reminder_sent')->default(false);
            $table->date('overdue_date')->nullable();
            $table->text('transaction_terms')->nullable();
            $table->text('notes')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurrence_period', ['weekly', 'monthly', 'yearly'])->nullable();
            $table->decimal('late_fee', 15, 2)->default(0);
            $table->decimal('penalty_rate', 5, 2)->default(0);
            $table->string('attachment_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
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
