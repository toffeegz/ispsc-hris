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
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('is_flexible');
            $table->date('date')->after('employee_id');
            $table->time('schedule_time_in')->after('time_out');
            $table->time('schedule_time_out')->after('schedule_time_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('is_flexible');
            $table->time('schedule_time_in');
            $table->time('schedule_time_out');
        });
    }
};
