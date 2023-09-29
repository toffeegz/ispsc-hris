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
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('employee_id')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('name_ext')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->char('sex', 50)->nullable();
            $table->char('civil_status', 100)->nullable();
            $table->char('citizenship', 100)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('tel_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->date('date_hired')->nullable();
            $table->uuid('user_id')->nullable();
            $table->uuid('department_id')->nullable();
            $table->uuid('position_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
