<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use App\Models\LeaveType;
use Illuminate\Support\Str;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveType::truncate();
        $leaveTypes = Config::get('hris_leave.leave_type');

        foreach ($leaveTypes as $leaveTypeData) {
            $id = null;

            if ($leaveTypeData['name'] === 'Sick Leave') {
                $id = LeaveType::SL_ID;
            } elseif ($leaveTypeData['name'] === 'Vacation Leave') {
                $id = LeaveType::VL_ID;
            }

            LeaveType::create([
                'id' => $id ? $id : Str::uuid(), // Assign the specific ID or generate a UUID
                'name' => $leaveTypeData['name'],
                'description' => $leaveTypeData['description'],
                'date_period' => $leaveTypeData['date_period'],
                'acronym' => $leaveTypeData['acronym'],
                'is_deletable' => false,
            ]);
        }
    }
}
