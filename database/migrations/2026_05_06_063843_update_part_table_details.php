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
    Schema::table('part', function (Blueprint $table) {
        $table->unsignedBigInteger('category_id')->nullable()->after('part_id');
        $table->string('unit_of_measure')->nullable()->after('stock_qty'); // cm, kg, pcs, liters
        $table->string('brand')->nullable()->after('part_name');
        
        // Linking the Category ID to the Categories table[cite: 8]
        $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
