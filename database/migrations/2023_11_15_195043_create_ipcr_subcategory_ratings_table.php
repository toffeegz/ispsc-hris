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
        Schema::create('ipcr_subcategory_ratings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ipcr_evaluation_id');
            $table->decimal('overall_rating', 5, 2)->nullable();
            $table->decimal('weighted_score', 5, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipcr_subcategory_ratings');
    }
};
