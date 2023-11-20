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
        Schema::create('opcr', function (Blueprint $table) {
            $table->id();
            $table->uuid('department_id');
            $table->string('department_head')->nullable();
            $table->string('department_name');
            $table->uuid('ipcr_period_id');
            $table->decimal('final_average_rating', 8, 2)->default(0);
            $table->timestamps();

            // Foreign keys
            // $table->foreign('department_id')->references('id')->on('departments');
            // // You might want to add foreign keys for other relationships as well, 
            // // such as 'department_head' if it relates to an employee table.

            // // Indexes
            // $table->index(['department_id', 'ipcr_period_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opcr');
    }
};
