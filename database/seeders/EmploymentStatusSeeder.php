<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmploymentStatus;
use Illuminate\Support\Facades\Config;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employmentStatusConfig = Config::get('hris_employee.employment_status');

        // Create an EmploymentStatus with the name and description from the configuration
        foreach($employmentStatusConfig as $employment_status_val) {
            EmploymentStatus::create([
                'name' => $employment_status_val, // You can use any key from the configuration array
                'description' => 'Description for Regular Employment', // Replace with the desired description
            ]);
        }
    }
}
