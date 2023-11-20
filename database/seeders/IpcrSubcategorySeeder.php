<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use App\Models\IpcrSubcategory;

class IpcrSubcategorySeeder extends Seeder
{
    public function run()
    {
        $config = config('hris.ipcr_subcategories');

        // Loop through the configuration and insert records into the database
        foreach ($config as $categoryId => $subcategories) {
            foreach ($subcategories as $subcategory) {
                $this->insertSubcategory($categoryId, $subcategory);
            }
        }
    }

    private function insertSubcategory($categoryId, $subcategory, $parentId = null)
    {
        $data = [
            'name' => $subcategory['name'],
            'weight' => $subcategory['weight'] ?? null,
            'parent_id' => $parentId,
        ];

        $subcat = IpcrSubcategory::create($data);

        if (isset($subcategory['children'])) {
            foreach ($subcategory['children'] as $child) {
                $this->insertSubcategory($categoryId, $child, $subcat->id);
            }
        }
    }
}
