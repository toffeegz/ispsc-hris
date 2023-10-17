<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use Illuminate\Support\Facades\Config;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedulesConfig = Config::get('hris.schedules');

        foreach ($schedulesConfig as $name => $scheduleData) {
            Schedule::create([
                'name' => $name,
                'is_default' => $scheduleData['is_default'],
                'time_in' => $scheduleData['in'],
                'time_out' => $scheduleData['out'],
                'is_deletable' => false, 
            ]);
        }
    }
}
