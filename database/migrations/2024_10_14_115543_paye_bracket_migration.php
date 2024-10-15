<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paye_brackets', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Use UUID for the primary key
            $table->decimal('limit', 15, 2); // Bracket limit, large enough to accommodate large numbers
            $table->decimal('rate', 5, 2); // Tax rate as a percentage (e.g., 0.25 for 25%)
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paye_brackets');
    }
};

