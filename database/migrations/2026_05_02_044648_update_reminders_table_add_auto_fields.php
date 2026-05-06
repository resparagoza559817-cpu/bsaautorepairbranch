<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reminders', function (Blueprint $table) {
            if (!Schema::hasColumn('reminders', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable()->after('job_order_id');
            }

            if (!Schema::hasColumn('reminders', 'type')) {
                $table->string('type')->default('manual');
            }

            if (!Schema::hasColumn('reminders', 'due_km')) {
                $table->integer('due_km')->nullable();
            }
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
