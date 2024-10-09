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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->char('Employee No');
            $table->string('Name');
            $table->string('Surname');
            $table->date('Start Date');
            $table->enum('Type',['Sick Leave','Marternity Leave','Annual Leave', 'Parental Leave','Unpaid Leave','Study Leave']);
            $table->boolean('is_approved')->default(0);
            $table->string('Reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};