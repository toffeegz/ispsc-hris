<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IpcrPeriod;

class IpcrPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the data for ipcr_periods
        $periods = [
            [
                'start_month' => 2,
                'end_month' => 7,
                'year' => 2020,
            ],
            [
                'start_month' => 8,
                'end_month' => 1,
                'year' => 2021,
            ],
            [
                'start_month' => 2,
                'end_month' => 7,
                'year' => 2021,
            ],
            [
                'start_month' => 8,
                'end_month' => 1,
                'year' => 2022,
            ],
            [
                'start_month' => 2,
                'end_month' => 7,
                'year' => 2022,
            ],
            [
                'start_month' => 8,
                'end_month' => 1,
                'year' => 2023,
            ],
        ];

        // Insert data into the database
        foreach ($periods as $period) {
            IpcrPeriod::create($period);
        }
    }
}
