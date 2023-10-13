<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = Config::get('hris_leave.leave_type');

        foreach ($leaveTypes as $leaveTypeData) {
            LeaveType::create([
                'name' => $leaveTypeData['name'],
                'description' => $leaveTypeData['description'],
                'date_period' => $leaveTypeData['date_period'],
                'is_deletable' => false
            ]);
        }
    }
}
