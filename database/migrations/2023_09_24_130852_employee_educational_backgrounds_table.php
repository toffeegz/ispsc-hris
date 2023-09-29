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
        Schema::create('employee_educational_backgrounds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->string('level'); // Elementary, Secondary, Vocational, College, Graduate Studies
            $table->string('school_name');
            $table->string('degree')->nullable();
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();
            $table->string('units_earned')->nullable(); 
            $table->string('year_graduated')->nullable();
            $table->string('academic_honors_received')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
