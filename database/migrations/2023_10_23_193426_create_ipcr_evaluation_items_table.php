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
        Schema::create('ipcr_evaluation_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('evaluation_id');
            $table->uuid('category_id');
            $table->uuid('item_id');
            $table->text('major_final_output')->nullable();
            $table->text('performance_indicators')->nullable();
            $table->text('target_of_accomplishment')->nullable();
            $table->text('actual_accomplishments')->nullable();
            $table->unsignedTinyInteger('rating_q')->nullable();
            $table->unsignedTinyInteger('rating_e')->nullable();
            $table->unsignedTinyInteger('rating_t')->nullable();
            $table->float('rating_a', 2, 1)->nullable(); // Example precision and scale, adjust as needed
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipcr_evaluation_items');
    }
};
