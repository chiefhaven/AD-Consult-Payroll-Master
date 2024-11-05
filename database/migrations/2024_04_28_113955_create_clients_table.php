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
            $table->uuid('id')->primary()->unique();
            $table->string('client_name');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            //$table->char('client_logo')->nullable();
            $table->char('phone')->nullable();
            $table->char('phone2')->nullable();
            $table->char('address')->nullable();
            $table->char('street_address')->nullable();
            $table->char('street_address_2')->nullable();
            $table->char('zip_postal_code')->nullable();
            $table->char('state')->nullable();
            $table->char('city')->nullable();
            $table->char('country_id')->nullable();
            $table->char('industry_id')->nullable();
            $table->string('website')->nullable();
            $table->char('tax_number_1')->nullable();
            $table->string('tax_label_1', 100)->nullable();
            $table->char('tax_number_2', 100)->nullable();
            $table->string('tax_label_2', 100)->nullable();
            $table->string('time_zone')->default('Africa/Blantyre');
            $table->char('status')->nullable();
            $table->char('project')->default(0);
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
