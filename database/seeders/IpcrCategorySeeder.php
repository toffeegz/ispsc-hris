<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IpcrCategory;

class IpcrCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the data from the configuration file
        $categories = config('hris.ipcr_categories');

        // Insert each category into the database
        foreach ($categories as $order => $categoryData) {
            IpcrCategory::create($categoryData);
        }
    }
}
