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
            $table->uuid('id')->primary(); // Ensure this is set to UUID
            $table->bigInteger('limit'); // Handles larger integers
            $table->decimal('rate', 5, 4); // Adjust the rate precision if necessary
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paye_brackets');
    }
};

