<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Award;
use Illuminate\Support\Carbon;

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
    
        // Loop through years from 6 years ago until 2023
        for ($year = date('Y') - 6; $year <= 2024; $year++) {
            foreach ($commonAwards as $awardName) {
                foreach ($employees as $employee) {
                    // Randomly determine the frequency (1-5 times per month)
                    $months = rand(1, 12);
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $months, $year);
                    $frequency = rand(1, 5);
    
                    for ($i = 0; $i < $frequency; $i++) {
                        $awardDate = Carbon::createFromDate($year, $months, rand(1, $daysInMonth));
    
                        Award::create([
                            'employee_id' => $employee->id,
                            'award_name' => $awardName,
                            'remarks' => 'Example remarks for ' . $awardName,
                            'date_awarded' => $awardDate,
                        ]);
                    }
                }
            }
        }
    }
    
}
