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
    Schema::create('stock_ins', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('part_id');
        $table->unsignedBigInteger('supplier_id');
        $table->integer('quantity_received');
        $table->decimal('cost_per_unit', 10, 2);
        $table->timestamp('stock_in_arrived');
        $table->timestamps();

        // Foreign keys ensure you can't delete a part or supplier that has stock history[cite: 24]
        $table->foreign('part_id')->references('part_id')->on('part')->onDelete('cascade');
        $table->foreign('supplier_id')->references('supplier_id')->on('supplier')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
