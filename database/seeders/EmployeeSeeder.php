<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Position;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ids = [
            "13015", "13016", "13034", "13052", "13081",
            "13097", "13108", "13123", "13153", "14178",
            "15205", "17023", "19069", "20082", "21110",
        ];

        $schedule = Schedule::where('is_default', false)->first(); // Get the first non-default schedule

        // Get all available positions
        $positions = Position::all();

        // Employee::truncate();
        $employees = Employee::factory()->count(15)->create([
            'employee_id' => function () use (&$ids) {
                return array_shift($ids);
            },
            'schedule_id' => function () use ($schedule) {
                return rand(0, 4) === 0 ? $schedule->id : null; // 20% chance of having a schedule
            },
            'position_id' => function () use ($ids) {
                return Position::inRandomOrder()->first()->id;
            },
            'department_id' => function (array $attributes) {
                $position = Position::find($attributes['position_id']);
                return $position->department_id;
            },
        ]);
        $this->call(EmployeeTrainingSeeder::class);

    }

}
