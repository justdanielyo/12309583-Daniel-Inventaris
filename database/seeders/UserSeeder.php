<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AKUN ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin', 
        ]);

        // AKUN STAFF
        User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('staff123'),
            'role' => 'staff',
        ]);
    }
}