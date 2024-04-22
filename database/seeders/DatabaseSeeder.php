<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    // boi pede pala paopen nung mysql phpmyadmin?sa browser
    public function run(): void
    {
        $this->call(ScheduleSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(PositionSeeder::class);

        // $this->call(EmployeeSeeder::class);
        $this->call(EmploymentStatusSeeder::class);
        $this->call(TrainingSeeder::class);
        // $this->call(EmployeeTrainingSeeder::class);
        // $this->call(UserSeeder::class);
        $this->call(LeaveTypeSeeder::class);
        // $this->call(LeaveSeeder::class);

        $this->call(IpcrPeriodSeeder::class);
        $this->call(IpcrCategorySeeder::class);
        $this->call(IpcrSubcategorySeeder::class);
        // $this->call(DepartmentHeadSeeder::class);
        // $this->call(AwardSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(AwardSeeder::class);
        $this->call(EmployeeTrainingSeeder::class);
        // $this->call(EmployeeAwardSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(LeaveSeeder::class); // changes from leave 
        $this->call(IpcrPeriodSeeder::class);
        $this->call(DepartmentHeadSeeder::class);


    }
}
