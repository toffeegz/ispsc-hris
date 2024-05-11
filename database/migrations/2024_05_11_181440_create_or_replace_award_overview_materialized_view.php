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
    public function up()
    {
        DB::statement("
            CREATE MATERIALIZED VIEW award_overview AS
            SELECT concat(e.last_name, ', ', e.first_name, ' ', e.middle_name) AS employee,
                d.name AS department_name,
                a.award_name,
                json_agg(a.date_awarded) AS date_awarded,
                max(a.date_awarded) AS last_date_awarded,
                count(*) AS frequency
            FROM ((employees e
                JOIN awards a ON ((e.id = a.employee_id)))
                JOIN departments d ON ((e.department_id = d.id)))
            GROUP BY e.first_name, e.last_name, e.middle_name, d.name, a.award_name
            WITH DATA;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS award_overview;');
    }
};
