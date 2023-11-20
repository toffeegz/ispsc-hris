<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\IpcrEvaluation;
use App\Models\Opcr;

class OpcrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch necessary data from related tables
        $opcrData = DB::table('departments')
            ->select(
                'departments.id as department_id',
                'departments.employee_id as department_head',
                'departments.name as department_name',
                'ip.ipcr_period_id as ipcr_period_id'
            )
            ->crossJoin(DB::raw('(SELECT DISTINCT id AS ipcr_period_id FROM ipcr_periods) AS ip'))
            ->leftJoin('employees', 'departments.id', '=', 'employees.department_id')
            ->leftJoin('ipcr_evaluations as ie', function ($join) {
                $join->on('employees.id', '=', 'ie.employee_id')
                    ->on('ip.ipcr_period_id', '=', 'ie.ipcr_period_id');
            })
            ->groupBy('departments.id', 'departments.employee_id', 'departments.name', 'ip.ipcr_period_id')
            ->havingRaw('COALESCE(SUM(ie.final_average_rating), 0) / NULLIF(COUNT(ie.id), 0) IS NOT NULL')
            ->get();

        // Insert data into the opcr table
        foreach ($opcrData as $data) {
            DB::table('opcr')->insert([
                'department_id' => $data->department_id,
                'department_head' => $data->department_head,
                'department_name' => $data->department_name,
                'ipcr_period_id' => $data->ipcr_period_id,
                // Adjust these values based on your actual requirements or use default values
                'final_average_rating' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
