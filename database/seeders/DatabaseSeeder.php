<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ScheduleSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(PositionSeeder::class);

        $this->call(EmployeeSeeder::class);
        $this->call(EmploymentStatusSeeder::class);
        $this->call(TrainingSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LeaveTypeSeeder::class);
        $this->call(LeaveSeeder::class);
    }
}
