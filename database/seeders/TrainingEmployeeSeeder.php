<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Training;
use App\Models\EmployeeTraining;

class TrainingEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Get all employees
       $employees = Employee::all();
        
       // Get all trainings
       $trainings = Training::all();
       
       // Loop through each employee
       foreach ($employees as $employee) {
           // Randomly choose number of trainings to attach (between 2 and 5)
           $numTrainings = rand(2, 5);
           
           // Randomly choose $numTrainings trainings
           $selectedTrainings = $trainings->random($numTrainings);
           
           // Attach selected trainings to employee
           foreach ($selectedTrainings as $training) {
               $employee->trainings()->attach($training->id);
           }
       }
   }
}
