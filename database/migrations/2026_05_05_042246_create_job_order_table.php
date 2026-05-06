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
       Schema::create('job_order', function ($table) {
    $table->id('job_order_id');
    $table->integer('customer_id')->nullable();
    $table->integer('vehicle_id')->nullable();
    $table->integer('staff_id')->nullable();
    $table->date('date_issued')->nullable();
    $table->decimal('total_cost', 10, 2)->nullable();
    $table->string('status', 50)->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_order');
    }
};
