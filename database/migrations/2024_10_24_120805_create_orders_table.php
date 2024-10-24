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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->constrained('billings')->onDelete('cascade'); // Reference to billing table
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Reference to product table
            $table->integer('quantity'); // Quantity of the product
            $table->decimal('rate', 10, 2); // Rate per unit of the product
            $table->decimal('total', 10, 2); // Total amount for this order line (quantity * rate)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
