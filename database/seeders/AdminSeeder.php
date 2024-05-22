<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
                'name' => 'Administrator',
                'email' => 'admin@pages.com',
                'password' => Hash::make('admin@pages.com'), 
                'phone' => '9191919191',
                'date_of_birth' => '1990-01-01',
                'role' => 'admin'
        ]);
    }
}
