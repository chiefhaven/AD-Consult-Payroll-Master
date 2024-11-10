<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Migration for creating tax_rates table
    public function up()
    {
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->uuid('id')->primary();  // UUID as primary key
            $table->string('tax_name');  // Name of the tax (e.g., VAT, Sales Tax)
            $table->decimal('rate', 10, 8);  // Tax rate as a percentage (e.g., 15.00 for 15%)
            $table->string('region')->nullable();  // The region or country the tax applies to
            $table->date('effective_date')->nullable();  // Date the tax rate becomes effective
            $table->string('tax_type')->default('percentage');  // Type of tax (e.g., percentage, fixed amount)
            $table->text('description')->nullable();  // Description or notes about the tax
            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_rates');
    }
};
