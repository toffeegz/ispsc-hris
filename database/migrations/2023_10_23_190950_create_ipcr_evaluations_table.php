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
        Schema::create('ipcr_evaluations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->uuid('ipcr_period_id');
            $table->uuid('reviewed_by')->nullable();
            $table->uuid('recommending_approval')->nullable();
            
            $table->decimal('mean_score_strategic', 5, 2)->nullable();
            $table->decimal('mean_score_core', 5, 2)->nullable();
            $table->decimal('mean_score_support', 5, 2)->nullable();

            $table->decimal('weighted_average_strategic', 5, 2)->nullable();
            $table->decimal('weighted_average_core', 5, 2)->nullable();
            $table->decimal('weighted_average_support', 5, 2)->nullable();

            $table->decimal('final_average_rating', 5, 2)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipcr_evaluations');
    }
};
