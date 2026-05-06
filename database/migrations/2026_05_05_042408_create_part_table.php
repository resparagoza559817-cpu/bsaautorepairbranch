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
    Schema::create('part', function ($table) {
        $table->id('part_id');
        $table->string('part_name', 100)->nullable();
        $table->string('description', 255)->nullable();
        $table->decimal('price', 10, 2)->nullable();
        $table->integer('stock_qty')->default(0); // Add this line[cite: 16]
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part');
    }
};
