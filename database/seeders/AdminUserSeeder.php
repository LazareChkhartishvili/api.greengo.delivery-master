<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create main admin user
        User::firstOrCreate(
            ['email' => 'admin@greengo.delivery'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'role_id' => 1, // Admin role
                'status_id' => 1, // Active status
                'email_verified_at' => now(),
            ]
        );

        // Create backup admin user
        User::firstOrCreate(
            ['email' => 'superadmin@greengo.delivery'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin2024!'),
                'role_id' => 1, // Admin role
                'status_id' => 1, // Active status
                'email_verified_at' => now(),
            ]
        );
    }
}
