<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin role
        $admin = Role::create([
            'id' => Role::ID_ADMIN,
            'name' => 'Administrator',
            'description' => null,
        ]);

        // Create Employee role
        $employee = Role::create([
            'id' => Str::uuid(),
            'name' => 'Employee',
            'description' => null,
        ]);
    }
}
