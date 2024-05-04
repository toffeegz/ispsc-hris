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
        Schema::table('leaves', function (Blueprint $table) {
            $table->date('date_filed')->nullable()->change();
            $table->string('time_start')->nullable()->change();
            $table->string('time_end')->nullable()->change();
            $table->decimal('credit', 8, 2)->default(0.00)->change();
            $table->text('details_of_leave')->nullable()->change();
            $table->boolean('commutation')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->date('date_filed')->nullable(false)->change();
            $table->string('time_start')->nullable(false)->change();
            $table->string('time_end')->nullable(false)->change();
            $table->decimal('credit', 8, 2)->default(0.00)->change();
            $table->text('details_of_leave')->nullable(false)->change();
            $table->boolean('commutation')->nullable(false)->change();
        });
    }
};
