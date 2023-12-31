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
        Schema::create('leaves', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->date('date_filed');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('time_start');
            $table->string('time_end');
            $table->uuid('leave_type_id');
            $table->tinyInteger('status')->comment('0 - on time, 1 - late filing')->default(0);
            $table->string('remarks')->nullable();
            $table->decimal('credit', 8, 2)->default(0.00);
            $table->text('details_of_leave');
            $table->text('disapproved_for')->nullable();
            $table->string('approved_for')->nullable();
            $table->tinyInteger('approved_for_type')->nullable();
            $table->boolean('commutation')->default(0);
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
