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
        Schema::create('human_resource_admins', function (Blueprint $table) {
            $table->id();
            $table->enum('prefix',['Mr.','Mrs.','Miss','Ms.']);
            $table->string('fname');
            $table->char('mname')->nullable();
            $table->string('lname');
            $table->char('phone');
            $table->char('phone2')->nullable();
            $table->char('current_address');
            $table->char('permanent_address')->nullable();
            $table->string('nextofkin');
            $table->date('dateofbirth');
            $table->enum('marital_status',['Single','Married','Divorced','Widowed','Separated', 'Unknown'])->default('Unknown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_r_admins');
    }
};
