<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // $sql = <<<SQL
        // CREATE MATERIALIZED VIEW opcr AS
        // SELECT
        //     departments.id AS department_id,
        //     departments.employee_id AS department_head,
        //     departments.name AS department_name,
        //     ip.ipcr_period_id AS ipcr_period_id,
        //     COALESCE(SUM(ie.final_average_rating), 0) / NULLIF(COUNT(ie.id), 0) AS final_average_rating,
        //     MIN(ie.created_at) AS created_at
        // FROM
        //     departments
        // CROSS JOIN
        //     (SELECT DISTINCT id AS ipcr_period_id FROM ipcr_periods) AS ip
        // LEFT JOIN
        //     employees ON departments.id = employees.department_id
        // LEFT JOIN
        //     ipcr_evaluations ie ON employees.id = ie.employee_id AND ip.ipcr_period_id = ie.ipcr_period_id
        // GROUP BY
        //     departments.id, departments.employee_id, departments.name, ip.ipcr_period_id
        // HAVING
        //     COALESCE(SUM(ie.final_average_rating), 0) / NULLIF(COUNT(ie.id), 0) IS NOT NULL;
        // SQL;
    
        // DB::statement($sql);
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('DROP MATERIALIZED VIEW IF EXISTS department_ratings;');
    }
};
