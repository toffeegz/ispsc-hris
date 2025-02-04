<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DB::statement('CREATE MATERIALIZED VIEW award_overview AS
        // SELECT 
        //     CONCAT(e.first_name, \' \', e.last_name) AS employee,
        //     d.name AS department_name,
        //     a.award_name,
        //     JSON_AGG(a.date_awarded) AS date_awarded,
        //     MAX(a.date_awarded) AS last_date_awarded,
        //     COUNT(*) AS frequency
        // FROM 
        //     employees e
        // JOIN 
        //     awards a ON e.id = a.employee_id
        // JOIN 
        //     departments d ON e.department_id = d.id
        // GROUP BY 
        //     e.first_name, 
        //     e.last_name, 
        //     d.name, 
        //     a.award_name');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awards_overview');
    }
};
