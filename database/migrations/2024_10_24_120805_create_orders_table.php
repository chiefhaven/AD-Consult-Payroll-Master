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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id');
            $table->foreignId('product_id');
            $table->integer('quantity');
            $table->decimal('rate', 10, 2);
            $table->decimal('total', 10, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->enum('discount_type',['trade','loyalty']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};