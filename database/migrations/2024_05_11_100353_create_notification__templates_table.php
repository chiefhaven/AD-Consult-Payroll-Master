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
        Schema::create('notification__templates', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['email','SMS','Push Notificatio']);
            $table->string('subject');
            $table->string('content');
            $table->char('recipient');
            $table->char('cc');
            $table->char('sender');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification__templates');
    }
};
