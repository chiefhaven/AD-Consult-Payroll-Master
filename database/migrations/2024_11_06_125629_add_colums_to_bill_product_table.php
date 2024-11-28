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
        Schema::table('bill_product', function (Blueprint $table) {
            $table->decimal('tax', 15, 2)->default(0)->after('item_discount')->change(); // Adds tax column after the discount column
            $table->string('taxType', 15)->default('None')->after('tax')->change(); // Adds taxType column after the tax column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bill_product', function (Blueprint $table) {
            //
        });
    }
};
