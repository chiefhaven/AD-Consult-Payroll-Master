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
            $table->id();
            $table->decimal('client_no');
            $table->string('client_name');
            $table->integer('currency_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->char('client_logo');
            $table->char('phone')->nullable();
            $table->char('phone2')->nullable();
            $table->char('address')->nullable();
            $table->char('zip_postal_code')->nullable();
            $table->char('state')->nullable();
            $table->char('city')->nullable();
            $table->char('country')->nullable();
            $table->char('industry')->nullable();
            $table->char('tax_number_1', 100);
            $table->string('tax_label_1', 100);
            $table->char('tax_number_2', 100)->nullable();
            $table->string('tax_label_2', 100)->nullable();
            $table->string('time_zone')->default('Africa/Blantyre');
            $table->char('contact_id');
            $table->char('status')->nullable();
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
