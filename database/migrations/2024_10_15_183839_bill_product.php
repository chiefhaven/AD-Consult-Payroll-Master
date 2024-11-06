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
            $table->id();
            $table->uuid('billing_id'); // UUID for the bill_id foreign key
            $table->uuid('product_id'); // UUID for the product_id foreign key
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2); // Price at the time of billing
            $table->decimal('item_discount', 15, 2)->default(0); // Price at the time of billing
            $table->decimal('tax', 15, 2)->default(0);
            $table->string('taxType', 15)->default('None');
            $table->decimal('total', 15, 2); // Calculated as quantity * price
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('billing_id')->references('id')->on('billings')->onDelete('cascade');
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
