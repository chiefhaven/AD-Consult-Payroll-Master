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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->char('employee_no', 6);
            $table->char('prefix', 6);
            $table->string('fname', 12);
            $table->char('mname', 1);
            $table->string('sname', 15);
            $table->char('phone', 4)->nullable();
            $table->char('phone2', 4)->nullable();
            $table->char('current_address', 6);
            $table->char('permanent_address', 6);
            $table->date('hiredate')->nullable();
            $table->smallInteger('education_level');
            $table->char('workdept_id', 3)->nullable();
            $table->char('designation_id', 8)->nullable();
            $table->char('id_type', 6);
            $table->char('id_number', 6);
            $table->char('id_proof', 6);
            $table->char('marital_status', 6);
            $table->char('gender', 1)->nullable();
            $table->date('birthdate')->nullable();
            $table->decimal('salary', 9, 2)->nullable();
            $table->decimal('bonus', 9, 2)->nullable();
            $table->char('contact', 6);
            $table->char('client_id', 6);
            $table->decimal('comment', 9, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
