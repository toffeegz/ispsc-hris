<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Award;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $commonAwards = [
            'Employee of the Month',
            'Exemplary Customer Service Award',
            'Team Player Award',
            'Innovation Excellence Award',
            // Add more common awards as needed
        ];

        $employees = Employee::all();

        foreach ($commonAwards as $awardName) {
            foreach ($employees as $employee) {
                // Randomly determine the frequency (1-5 times)
                $frequency = rand(1, 5);

                for ($i = 0; $i < $frequency; $i++) {
                    Award::create([
                        'employee_id' => $employee->id,
                        'award_name' => $awardName,
                        'remarks' => 'Example remarks for ' . $awardName,
                        'date_awarded' => now()->subDays(rand(1, 100)), // Random date in the past 100 days
                    ]);
                }
            }
        }
    }
}
