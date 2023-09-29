<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Department;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department_ids = Department::pluck('id'); // Pluck department IDs into an array

        Position::factory()
            ->count(20)
            ->create()
            ->each(function ($position) use ($department_ids) {
                $position->update([
                    'department_id' => $department_ids->random(),
                ]);
            });
    }
}
