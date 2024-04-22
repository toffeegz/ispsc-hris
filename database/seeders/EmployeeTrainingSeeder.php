<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Training;

class EmployeeTrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $employees = Employee::all();
        $trainings = Training::all();

        $numberOfRelationships = 50; 

        for ($i = 0; $i < $numberOfRelationships; $i++) {
            $randomEmployee = $employees->random();
            $randomTraining = $trainings->random();

            $randomEmployee->trainings()->syncWithoutDetaching([$randomTraining->id]);
        }
    }
}
