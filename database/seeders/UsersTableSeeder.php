<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Populate the users table with role_id 1
        User::factory()->count(5)->create(['role_id' => 1]);

        // Populate the users table with role_id 2
        User::factory()->count(2)->create(['role_id' => 2]);
    }
}
