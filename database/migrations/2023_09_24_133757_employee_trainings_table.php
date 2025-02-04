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
        Schema::create('employee_trainings', function (Blueprint $table) {
            $table->uuid('employee_id'); // Define employee_id as a UUID
            $table->uuid('training_id'); // Define training_id as a UUID
            // Other columns...

            // Set the primary key as a composite key
            $table->primary(['employee_id', 'training_id']);

            // Define foreign key constraints if needed
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('training_id')->references('id')->on('trainings');
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
