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
        Schema::create('finance_admins', function (Blueprint $table) {
            $table->id();
            $table->char('prefix');
            $table->string('fname');
            $table->char('mname');
            $table->string('lname');
            $table->char('phone');
            $table->char('phone2');
            $table->char('current_address');
            $table->char('permanent_address');
            $table->enum('marital_status',['Single','Married','Divorced','Widowed','Separated', 'Unknown']);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_admins');
    }
};
