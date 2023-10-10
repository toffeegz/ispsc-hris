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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('is_deletable')->default('YES');
            $table->string('date_period')->nullable();
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
