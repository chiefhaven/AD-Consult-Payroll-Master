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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();  // Set `id` as primary with UUID type
            $table->string('client_name');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('phone')->nullable();  // Use `string` instead of `char` for variable-length fields
            $table->string('phone2')->nullable();
            $table->string('address')->nullable();
            $table->string('street_address')->nullable();
            $table->string('street_address_2')->nullable();
            $table->string('zip_postal_code')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->uuid('country_id')->nullable();  // Assuming country and industry use UUIDs
            $table->uuid('industry_id')->nullable();
            $table->string('website')->nullable();
            $table->string('tax_number_1')->nullable();  // Adjusted type
            $table->string('tax_label_1', 100)->nullable();
            $table->string('tax_number_2')->nullable();
            $table->string('tax_label_2', 100)->nullable();
            $table->string('time_zone')->default('Africa/Blantyre');
            $table->string('status')->nullable();
            $table->boolean('project')->default(0);  // Use `boolean` for true/false values
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
