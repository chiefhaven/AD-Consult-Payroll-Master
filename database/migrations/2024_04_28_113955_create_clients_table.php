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
            $table->string('contact_person')->nullable();
            $table->enum('client_type', ['individual', 'corporate'])->default('corporate');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->decimal('contract_value', 15, 2)->nullable();
            $table->text('contract_terms')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('address')->nullable();
            $table->string('street_address')->nullable();
            $table->string('street_address_2')->nullable();
            $table->string('zip_postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->uuid('country_id')->nullable();  // Assuming country uses UUID
            $table->uuid('industry_id')->nullable(); // Assuming industry uses UUID
            $table->string('website')->nullable();
            $table->string('tax_number_1')->nullable();
            $table->string('tax_label_1', 100)->nullable();
            $table->string('tax_number_2')->nullable();
            $table->string('tax_label_2', 100)->nullable();
            $table->string('time_zone')->default('Africa/Blantyre');
            $table->enum('status', ['active', 'inactive', 'pending', 'suspended'])->default('active');
            $table->boolean('project')->default(0);  // Use `boolean` for true/false values
            $table->text('notes')->nullable();
            $table->string('reference_code')->nullable();
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
