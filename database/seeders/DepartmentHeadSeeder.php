<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;

class DepartmentHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $departments = Department::all();
        $employees = Employee::all();

        $departments->each(function ($department) use ($employees) {
            // Pick a random employee from the collection
            $randomEmployee = $employees->random();

            // Associate the random employee with the department
            $department->headEmployee()->associate($randomEmployee);
            $department->save();
        });
    }
}
