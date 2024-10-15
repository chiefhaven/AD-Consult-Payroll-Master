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
        Schema::create('bill_product', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Use UUID for the primary key
            $table->uuid('bill_id'); // UUID for the bill_id foreign key
            $table->uuid('product_id'); // UUID for the product_id foreign key
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2); // Price at the time of billing
            $table->decimal('total', 15, 2); // Calculated as quantity * price
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('bill_id')->references('id')->on('billings')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_product');
    }
};
