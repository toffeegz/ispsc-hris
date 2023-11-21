<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(20)->create();

        User::create([
            'name' => 'Gezryl', // Name of the user
            'email' => 'gezrylclarizg@gmail.com',
            'google_id' => null, // Google ID is set to null
            'role_id' => null, // Role ID is null
            'email_verified_at' => now(), // Email not verified yet
            'password' => bcrypt('password'), // Encrypting the password
        ]);
    }
}
