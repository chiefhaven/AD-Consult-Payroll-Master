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
        Schema::create('settings', function (Blueprint $table) {
            // Existing fields
            $table->string('prefix');
            $table->integer('startNumber');
            $table->decimal('taxRate', 5, 2);
            $table->text('terms')->nullable();
            $table->text('header');
            $table->text('footer');
            $table->string('seperator');
            $table->boolean('invoiceNumberIncludeClientName');
            $table->boolean('invoiceNumberIncludeYear');

            // Business information fields
            $table->string('business_name');
            $table->string('business_email');
            $table->string('business_phone');
            $table->string('business_website')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('tax_id')->nullable();

            // New address and contact fields
            $table->string('country')->nullable(); // e.g., "Malawi"
            $table->string('province_or_region')->nullable(); // e.g., "Central Region"
            $table->string('district')->nullable(); // e.g., "Lilongwe"
            $table->string('street_address')->nullable(); // Primary street address
            $table->string('street_address_2')->nullable(); // Additional address info (e.g., suite or building)
            $table->string('alt_phone_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
